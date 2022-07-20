<?php
    session_start();
    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/releases/'.$_REQUEST['parent_node'].'/'.$_REQUEST['test_id'];
    $redirect_url = $_REQUEST['redirect_uri'];

    $payload = new stdClass();
    $payload->test_status = $_REQUEST['test_status'];
    $payload->bug_no = $_REQUEST['bug_no'];
    $payload->test_run_link = $_REQUEST['test_run_link'];
    $result = json_decode($cta->httpPatchWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
    echo 'URL : '.$url.'<br> Payload: '.json_encode($payload).'<br> Result : '.$result;

    header("Location:".$redirect_url);
    exit();
?>