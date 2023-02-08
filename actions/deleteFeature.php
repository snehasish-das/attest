<?php
    session_start();
    $payload = new stdClass();
    $feature_id = $_REQUEST['feature_id'];
    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/features/'. $feature_id;
    $result = json_decode($cta->httpDeleteWithAuth($url,$_SESSION['auth-phrase']), true);
    echo 'Url: '.$url.'<br>Result : '.$result;

    if($result != '204'){
        $_SESSION['deleteTestError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/features');
    exit();

?>