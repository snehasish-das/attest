<?php
    session_start();
    $payload = new stdClass();
    $payload->name = $_REQUEST['name'];
    $payload->feature_type = $_REQUEST['feature_type'];
    $payload->status = $_REQUEST['status'];
    $payload->is_multi_sprint = $_REQUEST['is_multi_sprint'];
    $payload->description = $_REQUEST['description'];

    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/features';
    $result = json_decode($cta->httpPostWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
    echo 'Url: '.$url.'<br>Payload : '.json_encode($payload).'<br>Result : '.$result;

    if($result != '201'){
        $_SESSION['addFeatureError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/features');
    exit();

?>