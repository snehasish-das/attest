<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/features', function (Request $request, Response $response, array $args) {
    //$getFeatures = "SELECT * FROM `tcm_features` WHERE is_deleted=0 AND `created_date` > DATE_SUB(now(), INTERVAL 6 MONTH)";
    $getFeatures = "SELECT * FROM `tcm_features` WHERE is_deleted=0";

    
    $feature_ids = $request->getQueryParam('feature_id', $default = null);
    if ($feature_ids != null) {
        $features = explode(',',$feature_ids);
        $featureList = "'".$features[0]."'";
        for($i=1;$i<sizeof($features);$i++){
            $featureList .= ",'".$features[$i]."'";
        }
        $getFeatures .= " AND feature_id IN ( $featureList )";
    }

    $getFeatures .= " ORDER BY `created_date` DESC";
    //echo 'Query : '.$getFeatures;
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
        
        $addQuery = "INSERT INTO `tcm_features` (`feature_id`, `name`, `description`, `is_multi_sprint`, `created_by`, `last_updated_by`) VALUES (:feature_id, :name, :description, :is_multi_sprint, :created_by, :last_updated_by)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':feature_id', $feature_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':is_multi_sprint', $is_multi_sprint);
        $stmt->bindParam(':created_by', $_SESSION['id']);
        $stmt->bindParam(':last_updated_by', $_SESSION['id']);

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
    $emp_id = $_SESSION['id'];
    $updateQuery = "UPDATE `tcm_features` SET  `last_updated_by`='$emp_id'";
    $name = $request->getParam('name');
    if ($name != '') {
        $updateQuery .= ", `name`='$name'";
    }
    $description = $request->getParam('description');
    if ($description != '') {
        $updateQuery .= ", `description`='$description'";
    }
    $is_multi_sprint = $request->getParam('is_multi_sprint');
    if ($is_multi_sprint != '') {
       $updateQuery .= ", `is_multi_sprint`='$is_multi_sprint'";
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
    $emp_id = $_SESSION['id'];
    $deleteQuery = "UPDATE `tcm_features` SET `is_deleted`=1, `last_updated_by`='$emp_id' WHERE `feature_id`='$feature_id'";

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
