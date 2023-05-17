<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/tests', function (Request $request, Response $response, array $args) {
    $getTests = "SELECT tt.*, tu.name as user_name, tf.`name` as `feature_name`, tf.`status` as `feature_status`, tf.`feature_type` 
    FROM `tcm_tests` tt JOIN `tcm_users` tu ON tt.author=tu.id LEFT OUTER JOIN `tcm_features` tf ON tf.feature_id=tt.feature_id
    WHERE tt.is_deleted=0";

    $id = $request->getQueryParam('test_id', $default = null);
    if ($id != null) {
        $getTests .= " AND tt.id = '$id'";
    }

    $parent_node = $request->getQueryParam('parent_node', $default = null);
    if ($parent_node != null) {
        $getTests .= " AND parent_node = '$parent_node'";
    }

    $name = $request->getQueryParam('name', $default = null);
    if ($name != null) {
        $getTests .= " AND tt.`name` = '$name'";
    }

    $getTests .= " ORDER BY tt.name";

    //echo 'Query : '. $getTests;

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getTests);
        $tests = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($tests));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Create
$app->post('/tests', function (Request $request, Response $response) {
    $name = $request->getParam('name');
    if ($name == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Name is mandatory" }}');
    }
    $description = $request->getParam('description');
    $product = $request->getParam('product');
    if ($product == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Product is mandatory" }}');
    }
    $author = $request->getParam('author');
    if ($author == '') {
        $author = $_SESSION['id'];
    }
    $test_type = $request->getParam('test_type');
    $test_category = $request->getParam('test_category');
    $priority = $request->getParam('priority');
    if ($priority == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Priority is mandatory" }}');
    }
    $parent_node = $request->getParam('parent_node');
    if ($parent_node == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Parent node is mandatory" }}');
    }
    $scrum_name = $request->getParam('scrum_name');
    try {
        $db = new db();
        $db = $db->connect();
        
        $addQuery = "INSERT INTO `tcm_tests` (`name`, `description`, `product`, `author`, `test_type`, `test_category`, `priority`, `parent_node`, `scrum_name`, `created_by`, `last_updated_by`) VALUES (:name, :description, :product, :author, :test_type, :test_category, :priority, :parent_node, :scrum_name, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':test_type', $test_type);
        $stmt->bindParam(':test_category', $test_category);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':parent_node', $parent_node);
        $stmt->bindParam(':scrum_name', $scrum_name);
        $stmt->bindParam(':created_by', $_SESSION['id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['id']);

        if ($stmt->execute()) {
            $node = $db->query("SELECT * FROM tcm_tests WHERE `name`='$name'")->fetch(PDO::FETCH_ASSOC);
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
$app->patch('/tests/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $emp_id = $_SESSION['id'];
    $updateQuery = "UPDATE `tcm_tests` SET `last_updated_by`='$emp_id'";
    $name = $request->getParam('name');
    if ($name != '') {
        $updateQuery .= ", `name`='$name'";
    }
    $description = $request->getParam('description');
    if ($description != '') {
        $updateQuery .= ", `description`='$description'";
    }
    $product = $request->getParam('product');
    if ($product != '') {
        $updateQuery .= ", `product`='$product'";
    }
    $author = $request->getParam('author');
    if ($author != '') {
        $updateQuery .= ", `author`='$author'";
    }
    $steps = $request->getParam('steps');
    if ($steps != '') {
        $updateQuery .= ", `steps`='$steps'";
    }
    $expected_output = $request->getParam('expected_output');
    if ($expected_output != '') {
        $updateQuery .= ", `expected_output`='$expected_output'";
    }
    $test_type = $request->getParam('test_type');
    if ($test_type != '') {
        $updateQuery .= ", `test_type`='$test_type'";
    }
    $test_category = $request->getParam('test_category');
    if ($test_category != '') {
        $updateQuery .= ", `test_category`='$test_category'";
    }
    $priority = $request->getParam('priority');
    if ($priority != '') {
        $updateQuery .= ", `priority`='$priority'";
    }
    $automation_status = $request->getParam('automation_status');
    if ($automation_status != '') {
        $updateQuery .= ", `automation_status`='$automation_status'";
    }
    $automation_script_path = $request->getParam('automation_script_path');
    if ($automation_status != '') {
        $updateQuery .= ", `automation_script_path`='$automation_script_path'";
    }
    $automation_author = $request->getParam('automation_author');
    if ($automation_author != '') {
        $updateQuery .= ", `automation_author`='$automation_author'";
    }
    $tag = $request->getParam('tag');
    if ($tag != '') {
        $updateQuery .= ", `tag`='$tag'";
    }
    $scrum_name = $request->getParam('scrum_name');
    if ($scrum_name != '') {
        $updateQuery .= ", `scrum_name`='$scrum_name'";
    }
    $pages_involved = $request->getParam('pages_involved');
    if ($pages_involved != '') {
        $updateQuery .= ", `pages_involved`='$pages_involved'";
    }
    $feature_id = $request->getParam('feature_id');
    if ($feature_id != '') {
        $updateQuery .= ", `feature_id`='$feature_id'";
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
            $user = $db->query("SELECT * FROM tcm_tests WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);
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
$app->delete('/tests/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $emp_id = $_SESSION['id'];
    $deleteQuery = "UPDATE `tcm_tests` SET `is_deleted`=1, `last_updated_by`='$emp_id' WHERE `id`='$id'";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($deleteQuery);
        if ($stmt->execute()) {
            return $response->withStatus(204);
        } else {
            return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

//Get Test History
$app->get('/history/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    $emp_id = $_SESSION['id'];
    $getTestHistory = "SELECT * FROM `tcm_releases` WHERE `test_id`='$id' AND `is_deleted`=0 ORDER BY `execution_date` DESC LIMIT 5";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getTestHistory);
        $history = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($history));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Bulk Create/Update tests
$app->post('/upload-tests/{product}/{node}', function (Request $request, Response $response, array $args) {
    $product = $args['product'];
    $node = $args['node'];
    $params = (array)$request->getParsedBody();
    $total = sizeof ($params);
    echo 'Total rows:'. $total;
    //echo '<hr> First value: '. $params[$i]['name'];
    try {
        $db = new db();
        $db = $db->connect();
        //$count = 1; 
        //$totalIterations = ($total%50 == 0) ? $total/50 : ($total/50)+1;

        $query = "INSERT INTO `tcm_tests` (`name`, `description`, `product`, `author`, `test_type`, `test_category`, `priority`, `parent_node`, `scrum_name`, `steps`, `expected_output`, `automation_status`, `automation_script_path`, `automation_author`, `tag`, `feature_id`, `created_by`, `last_updated_by`) VALUES ";
        for($i=0; $i<$total; $i++){
            //echo 'iteration:'. $i+1;
            if(isset($params[$i]['author']) && $params[$i]['author'] != ''){
                $author_query = "SELECT `id` FROM tcm_users WHERE `email`='".$params[$i]['author']."'";
                $user = $db->query($author_query)->fetch(PDO::FETCH_ASSOC);
                $author = $user['id'];
            }else{
                $author = $_SESSION['id'];
            }
            //echo 'Author:'.$author;
            if(isset($params[$i]['automation_author']) && $params[$i]['automation_author'] != ''){
                $automation_author_query = "SELECT `id` FROM tcm_users WHERE `email`='".$params[$i]['automation_author']."'";
                $user1 = $db->query($automation_author_query)->fetch(PDO::FETCH_ASSOC);
                $automation_author = $user1['id'];
            }else{
                $automation_author = $_SESSION['id'];
            }
            //echo 'Automation Author:'.$automation_author;

            $row = "('" .$params[$i]['name']. "', '" . $params[$i]['description']. "', '" . $product. "', '" . $author . "', '" . $params[$i]['test_type']. "', '" . $params[$i]['test_category']. "', '" . $params[$i]['priority']. "', '" . $node. "', '" . $params[$i]['scrum_name']. "', '" . $params[$i]['steps']. "', '" . $params[$i]['expected_output']. "', '" . $params[$i]['automation_status']. "', '" . $params[$i]['automation_script_path']. "', '" . $automation_author . "', '" . $params[$i]['tag']. "', '" . $params[$i]['feature_id']. "', '" .$_SESSION['id']. "', '" .$_SESSION['id']. "')";
            
            //echo 'Adding '. $row;
            if(($i+1) % 50 == 0){
                echo 'Final Query: '.$query;
                $query = $query.''.$row;
                $res = $db->prepare($query)->execute();
                echo 'Result:'.json_decode($res);
                $query = "INSERT INTO `tcm_tests` (`name`, `description`, `product`, `author`, `test_type`, `test_category`, `priority`, `parent_node`, `scrum_name`, `steps`, `expected_output`, `automation_status`, `automation_script_path`, `automation_author`, `tag`, `feature_id`, `created_by`, `last_updated_by`) VALUES ";
            }else{
                $query = $query.''.$row.', ';
            }
        }
        //$res = $db->prepare($query)->execute();

        return $response->withStatus(200)->write('"Success":{"text":" '.$total.' records uploaded"}');
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());