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

    $phone = $request->getParam('phone');
    if ($phone == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Phone is mandatory" }}');
    }

    $password = $request->getParam('password');
    if ($password == '') {
        return $response->withStatus(400)->write('{"error" : {"text": "Password is mandatory" }}');
    }
    else{
        $password = md5($password);
    }
    $dob = $request->getParam('dob');
    $dob = date('Y-m-d',strtotime($dob));
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $zip = $request->getParam('zip');
    $image = $request->getParam('image');
    $role = $request->getParam('role');
    $company = $request->getParam('company');
    $website = $request->getParam('website');
    $whatsapp = $request->getParam('whatsapp');
    $is_phone_verified = $request->getParam('is_phone_verified');
    if(!isset($is_phone_verified)){
        $is_phone_verified=0;
    }
    $is_email_verified = $request->getParam('is_email_verified');
    if(!isset($is_email_verified)){
        $is_email_verified=0;
    }

    try {
        $db = new db();
        $db = $db->connect();
        
        $user = $db->query("SELECT `user_id`, `name`, `email`, `phone`, `dob`, `address`, `city`, `zip`, `image`, `role`, `company`, `website`, `whatsapp`, `is_phone_verified`, `is_email_verified` FROM tcm_users WHERE phone='$phone'")->fetch(PDO::FETCH_ASSOC);
        if(@$user['phone'] != ''){
            return $response->withStatus(400)->write('{"error" : {"text": "Phone is already registered" } }');
        }

        $user = $db->query("SELECT `user_id`, `name`, `email`, `phone`, `dob`, `address`, `city`, `zip`, `image`, `role`, `company`, `website`, `whatsapp`, `is_phone_verified`, `is_email_verified` FROM tcm_users WHERE email='$email'")->fetch(PDO::FETCH_ASSOC);
        if(@$user['email'] != ''){
            return $response->withStatus(400)->write('{"error" : {"text": "Email is already registered" } }');
        }

        $addQuery = "INSERT INTO `tcm_users` (`user_id`, `name`, `email`, `phone`, `password`, `dob`, `address`, `city`, `zip`, `image`, `role`, `company`, `website`, `whatsapp`, `is_phone_verified`, `is_email_verified`) VALUES ((SELECT UUID()), :name, :email, :phone, :password, :dob, :address, :city, :zip, :image, :role, :company, :website, :whatsapp, :is_phone_verified, :is_email_verified)";

        $stmt = $db->prepare($addQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':whatsapp', $whatsapp);
        $stmt->bindParam(':is_phone_verified', $is_phone_verified);
        $stmt->bindParam(':is_email_verified', $is_email_verified);

        if ($stmt->execute()) {
            $user = $db->query("SELECT `user_id`, `name` as `user_name`, `email` as `user_email`, `phone`, `dob`, `address`, `city`, `zip`, `image`, `role`, `company`, `website`, `whatsapp`, `is_phone_verified`, `is_email_verified` FROM tcm_users WHERE email='$email'")->fetch(PDO::FETCH_ASSOC);
            $user['register_otp'] = substr(rand(),0,6);
            //$user['register_otp'] = time();
            $email_gateway = new EmailMiddleware;
            $email_gateway->sendEmail("Register OTP", $user);
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
    $name = $request->getParam('name');
    if ($name != '') {
        if($index > 0)
            $updateQuery .= ", `name`='$name'";
        else
            $updateQuery .= " `name`='$name'";
        $index++;
    }
    $dob = $request->getParam('dob');
    if ($dob != '') {
        $dob = date('Y-m-d',strtotime($dob));
        if($index > 0)
            $updateQuery .= ", `dob`='$dob'";
        else
            $updateQuery .= " `dob`='$dob'";
        $index++;
    }
    $address = $request->getParam('address');
    if ($address != '') {
        if($index > 0)
            $updateQuery .= ", `address`='$address'";
        else
            $updateQuery .= " `address`='$address'";
        $index++;
    }
    $city = $request->getParam('city');
    if ($city != '') {
        if($index > 0)
            $updateQuery .= ", `city`='$city'";
        else
            $updateQuery .= " `city`='$city'";
        $index++;
    }
    $zip = $request->getParam('zip');
    if ($zip != '') {
        if($index > 0)
            $updateQuery .= ", `zip`='$zip'";
        else
            $updateQuery .= " `zip`='$zip'";
        $index++;
    }
    $image = $request->getParam('image');
    if ($image != '') {
        if($index > 0)
            $updateQuery .= ", `image`='$image'";
        else
            $updateQuery .= " `image`='$image'";
        $index++;
    }
    $company = $request->getParam('company');
    if ($company != '') {
        if($index > 0)
            $updateQuery .= ", `company`='$company'";
        else
            $updateQuery .= " `company`='$company'";
        $index++;
    }
    $website = $request->getParam('website');
    if ($website != '') {
        if($index > 0)
            $updateQuery .= ", `website`='$website'";
        else
            $updateQuery .= " `website`='$website'";
        $index++;
    }
    $whatsapp = $request->getParam('whatsapp');
    if ($whatsapp != '') {
        if($index > 0)
            $updateQuery .= ", `whatsapp`='$whatsapp'";
        else
            $updateQuery .= " `whatsapp`='$whatsapp'";
        $index++;
    }
    $is_email_verified = $request->getParam('is_email_verified');
    if ($is_email_verified != '') {
        if($index > 0)
            $updateQuery .= ", `is_email_verified`='$is_email_verified'";
        else
            $updateQuery .= " `is_email_verified`='$is_email_verified'";
        $index++;
    }
    $is_phone_verified = $request->getParam('is_phone_verified');
    if ($is_phone_verified != '') {
        if($index > 0)
            $updateQuery .= ", `is_phone_verified`='$is_phone_verified'";
        else
            $updateQuery .= " `is_phone_verified`='$is_phone_verified'";
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
            $user = $db->query("SELECT `user_id`, `name`, `email`, `phone`, `dob`, `address`, `city`, `zip`, `image`, `role`, `company`, `website`, `whatsapp`, `is_phone_verified`, `is_email_verified` FROM tcm_users WHERE `user_id`='$id'")->fetch(PDO::FETCH_ASSOC);
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
