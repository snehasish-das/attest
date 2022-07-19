<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/releases/{parent_node}', function (Request $request, Response $response, array $args) {
    $parent_node = $args['parent_node'];
    $getReleases = "SELECT tr.`name`, tr.`test_id`, tt.`name` as test_name, tt.`product`, tt.`priority`, tt.`tag`, tt.`scrum_name`, tr.`test_status`, tr.`execution_date`, tr.`bug_no`, tr.`test_run_link`, FROM `tcm_releases` tr, `tcm_tests` tt 
    WHERE tt.id=tr.test_id AND tr.`parent_node`='$parent_node' AND tr.is_deleted=0 ORDER BY `execution_date`";


    // $parent_node = $request->getQueryParam('parent_node', $default = null);
    // if ($parent_node != null) {
    //     $getReleases .= " AND parent_node = '$parent_node'";
    // }

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getReleases);
        $releases = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($releases));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Create
$app->post('/releases', function (Request $request, Response $response) {
    $name = $request->getParam('name');
    if ($name == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Name is mandatory" }}');
    }
    $description = $request->getParam('description');
    $test_id = $request->getParam('test_id');
    if ($test_id == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Test ID is mandatory" }}');
    }
    $test_status = $request->getParam('test_status');
    if ($test_status == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Test status is mandatory" }}');
    }
    $execution_date = date_create()->format('Y-m-d');
    $test_run_type = $request->getParam('test_run_type');
    $bug_no = $request->getParam('bug_no');
    $test_run_link = $request->getParam('test_run_link');
    try {
        $db = new db();
        $db = $db->connect();
        
        $addQuery = "INSERT INTO `tcm_releases` (`name`, `description`, `test_id`, `author`, `test_status`, `execution_date`, `test_run_type`, `bug_no`, `test_run_link`, `created_by`, `last_updated_by`) VALUES (:name, :description, :test_id, :author, :test_status, :execution_date, :test_run_type, :bug_no, :test_run_link, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':test_id', $test_id);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':test_status', $test_status);
        $stmt->bindParam(':execution_date', $execution_date);
        $stmt->bindParam(':test_run_type', $test_run_type);
        $stmt->bindParam(':bug_no', $bug_no);
        $stmt->bindParam(':test_id', $test_id);
        $stmt->bindParam(':test_run_link', $test_run_link);
        $stmt->bindParam(':created_by', $_SESSION['id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['id']);

        if ($stmt->execute()) {
            $node = $db->query("SELECT * FROM tcm_releases WHERE `name`='$name'")->fetch(PDO::FETCH_ASSOC);
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
$app->patch('/releases/{name}/{test_id}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $test_id = $args['test_id'];
    $emp_id = $_SESSION['id'];

    $updateQuery = "UPDATE `tcm_releases` SET `last_updated_by`='$emp_id'";
    $test_status = $request->getParam('test_status');
    if ($test_status != '') {
        $updateQuery .= ", `test_status`='$test_status'";
    }
    $execution_date = $request->getParam('execution_date');
    if ($execution_date != '') {
        $execution_date = date_format($execution_date,"Y-m-d");
        $updateQuery .= ", `execution_date`='$execution_date'";
    }
    $test_run_type = $request->getParam('test_run_type');
    if ($test_run_type != '') {
        $updateQuery .= ", `test_run_type`='$test_run_type'";
    }
    $bug_no = $request->getParam('bug_no');
    if ($bug_no != '') {
        $updateQuery .= ", `bug_no`='$bug_no'";
    }
    $test_run_link = $request->getParam('test_run_link');
    if ($test_run_link != '') {
        $updateQuery .= ", `test_run_link`='$test_run_link'";
    }

    $updateQuery .= " WHERE `test_id`='$test_id' AND `name`='$name'";
    //echo 'UpdateQuery : '.$updateQuery;

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($updateQuery);
        if ($stmt->execute()) {
            $user = $db->query("SELECT * FROM tcm_releases WHERE `name`='$name'")->fetch(PDO::FETCH_ASSOC);
            return $response->withStatus(200)->write(json_encode($user));
        } else {
            return $response->withStatus(400)->write('"UpdateError":{"text":"Oops something went wrong, are you sure this the right payload?"}');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());


// Remove Association of Test from release
$app->delete('/releases/{name}/{test_id}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $test_id = $args['test_id'];
    $emp_id = $_SESSION['id'];
    $deleteQuery = "DELETE from `tcm_releases` SET `is_deleted`=1, `last_updated_by`='$emp_id' WHERE `test_id`='$test_id' AND `name`='$name'";

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
