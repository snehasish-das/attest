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
        
        $addQuery = "INSERT INTO `tcm_tests` (`name`, `description`, `product`, `author`, `test_type`, `priority`, `parent_node`, `scrum_name`, `created_by`, `last_updated_by`) VALUES (:name, :description, :product, :author, :test_type, :priority, :parent_node, :scrum_name, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':test_type', $test_type);
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
