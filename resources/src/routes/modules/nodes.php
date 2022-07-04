<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/nodes', function (Request $request, Response $response, array $args) {
    $getNodes = "SELECT * FROM `tcm_nodes` WHERE is_deleted=0 ORDER BY ";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getNodes);
        $nodes = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($nodes));
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
    if ($node_type != 'testplan' || $node_type != 'testlab') {
        return $response->withStatus(400)->write('{"error" : {"text": "Node type can either be testplan or testlab" }}');
    }

    $distance_from_root = $request->getParam('distance_from_root');
    if ($distance_from_root == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Distance is mandatory" }}');
    }

    try {
        $db = new db();
        $db = $db->connect();
        
        $addQuery = "INSERT INTO `tcm_nodes` (`id`, `node_name`, `parent_node`, `node_type`, `distance_from_root`, `created_by`, `last_updated_by`) VALUES ((SELECT UUID()), :node_name, :parent_node, :node_type, :distance_from_root, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':node_name', $node_name);
        $stmt->bindParam(':parent_node', $parent_node);
        $stmt->bindParam(':node_type', $node_type);
        $stmt->bindParam(':distance_from_root', $distance_from_root);
        $stmt->bindParam(':created_by', $_SESSION['emp_id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['emp_id']);

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
    
    $updateQuery = "UPDATE `tcm_nodes` SET ";
    $index=0;
    $node_name = $request->getParam('node_name');
    if ($node_name != '') {
        if($index > 0)
            $updateQuery .= ", `node_name`='$node_name'";
        else
            $updateQuery .= " `node_name`='$node_name'";
        $index++;
    }
    $parent_node = $request->getParam('parent_node');
    if ($parent_node != '') {
        if($index > 0)
            $updateQuery .= ", `parent_node`='$parent_node'";
        else
            $updateQuery .= " `parent_node`='$parent_node'";
        $index++;
    }
    $distance_from_root = $request->getParam('distance_from_root');
    if ($distance_from_root != '') {
        if($index > 0)
            $updateQuery .= ", `distance_from_root`='$distance_from_root'";
        else
            $updateQuery .= " `distance_from_root`='$distance_from_root'";
        $index++;
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
    $deleteQuery = "UPDATE `tcm_nodes` SET `is_deleted`=1 WHERE `id`='$id'";

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
