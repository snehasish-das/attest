<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/users', function (Request $request, Response $response, array $args) {
    $getUser = "SELECT * FROM `tcm_users` where is_deleted=0 ";

    $email = $request->getQueryParam('email', $default = null);
    if ($email != null) {
        $getUser .= " AND `email`='$email'";
    }

    $phone = $request->getQueryParam('phone', $default = null);
    if ($phone != null) {
        $getUser .= " AND `phone`='$phone'";
    }

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getUser);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($user));
    } catch (PDOException $e) {
        return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

//Get
$app->get('/users/login', function (Request $request, Response $response) {
    $id = $_SESSION['id'];
    try {
        $db = new db();
        $db = $db->connect();
        $user = $db->query("SELECT * FROM tcm_users WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);
        if (sizeof($user) > 0) {
            return $response->withStatus(200)->write(json_encode($user));
        }
        else{
            return $response->withStatus(400)->write('{"error" : {"text": "Invalid Credentials" }');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());

// Register
$app->post('/users', function (Request $request, Response $response) {
    $name = $request->getParam('name');
    if ($name == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Name is mandatory" }');
    }
    $email = $request->getParam('email');
    if ($email == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Email is mandatory" }}');
    }

    $password = $request->getParam('password');
    if ($password == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Password is mandatory" }}');
    }
    else{
        $password = md5($password);
    }
    $role = $request->getParam('role');
    if ($role == '') {
        $role='manager';
    }
    $user_id = $request->getParam('user_id');
    $created_by = $request->getParam('created_by');
    $last_updated_by = $request->getParam('last_updated_by');

    try {
        $db = new db();
        $db = $db->connect();

        $addQuery = "INSERT INTO `tcm_users` (`id`, `name`, `email`, `password`, `role`, `created_by`, `last_updated_by`) VALUES ((SELECT UUID()), :name, :email, :password, :role, :created_by, :last_updated_by) ON DUPLICATE KEY UPDATE `last_updated_by`=:last_updated_by, `password`=:password, `role`=:role";

        if ($user_id != '') {
            $addQuery = "INSERT INTO `tcm_users` (`id`, `name`, `email`, `password`, `role`, `created_by`, `last_updated_by`) VALUES ('$user_id', :name, :email, :password, :role, :created_by, :last_updated_by) ON DUPLICATE KEY UPDATE `last_updated_by`=:last_updated_by, `password`=:password, `role`=:role";
        }

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':last_updated_by', $last_updated_by);

        if ($stmt->execute()) {
            $user = $db->query("SELECT `id`, `name` as `user_name`, `email` as `user_email`, `role` FROM tcm_users WHERE email='$email'")->fetch(PDO::FETCH_ASSOC);
            return $response->withStatus(201)->write(json_encode($user));
        } else {
            return $response->withStatus(400)->write('"AddError":{"text":"Oops something went wrong, are you sure this the right payload?"}');
        }
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
});

// Update
$app->patch('/users', function (Request $request, Response $response) {
    $updateQuery = "UPDATE `tcm_users` SET ";
    $index=0;
    $role = $request->getParam('role');
    if ($role != '') {
        if($index > 0)
            $updateQuery .= ", `role`='$role'";
        else
            $updateQuery .= " `role`='$role'";
        $index++;
    }
    $password = $request->getParam('password');
    if ($password != '') {
        if($index > 0)
            $updateQuery .= ", `password`='".md5($password)."'";
        else
            $updateQuery .= " `password`='".md5($password)."'";
        $index++;
    }

    $id = $_SESSION['user_id'];

    $updateQuery .= " WHERE `user_id`='$id'";
    //echo 'UpdateQuery : '.$updateQuery;

    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->prepare($updateQuery);
        if ($stmt->execute()) {
            $user = $db->query("SELECT `user_id`, `name` as `user_name`, `email` as `user_email`, `role` FROM tcm_users WHERE `user_id`='$id'")->fetch(PDO::FETCH_ASSOC);
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
$app->delete('/users', function (Request $request, Response $response) {
    $id = $_SESSION['user_id'];
    $deleteQuery = "UPDATE `tcm_users` SET `is_deleted`=1 WHERE `user_id`='$id'";

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
