<?php
    session_start();
    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/releases';

    $parent_node = $_REQUEST['parent_node'];
    $redirect_url = $_REQUEST['redirect_uri'];
    $test_ids = $_REQUEST['test_id'];

    $payload = new stdClass();
    $payload->parent_node = $parent_node;
    for($i=0; $i<sizeof($test_ids);$i++){
        $payload->test_id = $test_ids[$i];
        $result = json_decode($cta->httpPostWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
        echo 'URL : '.$url.'<br> Payload: '.json_encode($payload).'<br> Result : '.$result;
    }

    header("Location:".$redirect_url);
    exit();
?>