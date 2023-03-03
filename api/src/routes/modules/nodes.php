<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/nodes', function (Request $request, Response $response, array $args) {
    $node_type = $request->getQueryParam('node_type', $default = null);
    try {
        $db = new db();
        $db = $db->connect();
        $data = getNodeData($node_type,null,$db);

        return $response->withStatus(200)->write(json_encode($data));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }

    $db = null;

})->add(new UserMiddleware());

//Get root nodes
$app->get('/nodes/root', function (Request $request, Response $response, array $args) {
    $getRootNodes = "SELECT * FROM `tcm_nodes` WHERE is_deleted=0 AND parent_node is NULL AND node_type='testplan' ORDER BY node_name";
    //echo 'Query : '.$getRootNodes;
    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getRootNodes);
        $rootNodes = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($rootNodes));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Create
$app->post('/nodes', function (Request $request, Response $response) {
    $node_name = $request->getParam('node_name');
    if ($node_name == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Node name is mandatory" }');
    }
    $parent_node = $request->getParam('parent_node');
    if ($parent_node == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Parent node is mandatory" }}');
    }

    $node_type = $request->getParam('node_type');
    if ($node_type != 'testplan' && $node_type != 'testlab') {
        return $response->withStatus(400)->write('{"error" : {"text": "Node type can either be testplan or testlab" }}');
    }

    try {
        $db = new db();
        $db = $db->connect();
        
        $addQuery = "INSERT INTO `tcm_nodes` (`id`, `node_name`, `parent_node`, `node_type`, `created_by`, `last_updated_by`) VALUES ((SELECT UUID()), :node_name, :parent_node, :node_type, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':node_name', $node_name);
        $stmt->bindParam(':parent_node', $parent_node);
        $stmt->bindParam(':node_type', $node_type);
        $stmt->bindParam(':created_by', $_SESSION['id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['id']);

        if ($stmt->execute()) {
            $node = $db->query("SELECT * FROM tcm_nodes WHERE node_name='$node_name'")->fetch(PDO::FETCH_ASSOC);
            return $response->withStatus(201)->write(json_encode($node));
        } else {
            return $response->withStatus(400)->write('"AddError":{"text":"Oops! something went wrong, are you sure this the right payload?"}');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Update
$app->patch('/nodes/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $emp_id = $_SESSION['id'];
    $updateQuery = "UPDATE `tcm_nodes` SET `last_updated_by`='$emp_id'";
    $node_name = $request->getParam('node_name');
    if ($node_name != '') {
        $updateQuery .= ", `node_name`='$node_name'";
    }
    $parent_node = $request->getParam('parent_node');
    if ($parent_node != '') {
        $updateQuery .= ", `parent_node`='$parent_node'";
    }

    $updateQuery .= " WHERE `id`='$id'";
    //echo 'UpdateQuery : '.$updateQuery;

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($updateQuery);
        if ($stmt->execute()) {
            $user = $db->query("SELECT * FROM tcm_nodes WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);
            return $response->withStatus(200)->write(json_encode($user));
        } else {
            return $response->withStatus(400)->write('"UpdateError":{"text":"Oops something went wrong, are you sure this the right payload?"}');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());


// Delete
$app->delete('/nodes/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $emp_id = $_SESSION['id'];
    $deleteQuery = "UPDATE `tcm_nodes` SET `is_deleted`=1, `last_updated_by`='$emp_id' WHERE `id`='$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($deleteQuery);
        if ($stmt->execute()) {
            return $response->withStatus(204);
        } else {
            return $response->withStatus(400)->write('"DeleteError":{"text":"Invalid Credentials"} }');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());



function getNodeData($node_type, $parent_node, $db){
    $getNodeForParent = "SELECT nd.node_name, nd.parent_node FROM tcm_nodes nd WHERE node_type = '$node_type'";
    if($parent_node ==''){
        $getNodeForParent.= " AND nd.`parent_node` IS NULL";
    } else{
        $getNodeForParent .= " AND nd.`parent_node` = '$parent_node'";
    }
    $getNodeForParent .= " ORDER BY nd.parent_node,nd.node_name";

    //echo "Query : ". $getNodeForParent;
    $stmt = $db->query($getNodeForParent);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = array();
    foreach($result as $row){
        $sub_array = array();
        $currNode = $row['node_name'];
        $sub_array['node_name'] = $currNode;
        $sub_array['parent_node'] = $row['parent_node'];

        $tests = $db->query("SELECT id, name FROM tcm_tests where parent_node='$currNode'")->fetchAll(PDO::FETCH_OBJ);
        $sub_array['tests'] = $tests;
        $sub_array['nodes'] = array_values(getNodeData($node_type,$row['node_name'],$db));
        $output[] = $sub_array;
    }

    return $output;
}
