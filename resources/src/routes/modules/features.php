<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/features', function (Request $request, Response $response, array $args) {
    $getFeatures = "SELECT * FROM `tcm_features` WHERE is_deleted=0 ORDER BY ";

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getFeatures);
        $features = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($features));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Create
$app->post('/features', function (Request $request, Response $response) {
    $feature_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    $name = $request->getParam('name');
    if ($name == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Name is mandatory" }}');
    }

    $description = $request->getParam('description');
    $is_multi_sprint = $request->getParam('is_multi_sprint');
    try {
        $db = new db();
        $db = $db->connect();
        
        $addQuery = "INSERT INTO `tcm_features` (`id`, `feature_id`, `name`, `description`, `is_multi_sprint`, `created_by`, `last_updated_by`) VALUES ((SELECT UUID()), :feature_id, :name, :description, :is_multi_sprint, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':feature_id', $feature_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':is_multi_sprint', $is_multi_sprint);
        $stmt->bindParam(':created_by', $_SESSION['emp_id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['emp_id']);

        if ($stmt->execute()) {
            $node = $db->query("SELECT * FROM tcm_features WHERE feature_id='$feature_id'")->fetch(PDO::FETCH_ASSOC);
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
$app->patch('/features/{feature_id}', function (Request $request, Response $response, array $args) {
    $feature_id = $args['feature_id'];
    
    $updateQuery = "UPDATE `tcm_features` SET ";
    $index=0;
    $name = $request->getParam('name');
    if ($name != '') {
        if($index > 0)
            $updateQuery .= ", `name`='$name'";
        else
            $updateQuery .= " `name`='$name'";
        $index++;
    }
    $description = $request->getParam('description');
    if ($description != '') {
        if($index > 0)
            $updateQuery .= ", `description`='$description'";
        else
            $updateQuery .= " `description`='$description'";
        $index++;
    }
    $is_multi_sprint = $request->getParam('is_multi_sprint');
    if ($is_multi_sprint != '') {
        if($index > 0)
            $updateQuery .= ", `is_multi_sprint`='$is_multi_sprint'";
        else
            $updateQuery .= " `is_multi_sprint`='$is_multi_sprint'";
        $index++;
    }

    $updateQuery .= " WHERE `feature_id`='$feature_id'";
    //echo 'UpdateQuery : '.$updateQuery;

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($updateQuery);
        if ($stmt->execute()) {
            $user = $db->query("SELECT * FROM tcm_features WHERE `feature_id`='$feature_id'")->fetch(PDO::FETCH_ASSOC);
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
$app->delete('/features/{feature_id}', function (Request $request, Response $response, array $args) {
    $feature_id = $args['feature_id'];
    $deleteQuery = "UPDATE `tcm_features` SET `is_deleted`=1 WHERE `feature_id`='$feature_id'";

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
