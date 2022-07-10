<?php
    session_start();
    $payload = new stdClass();
    $payload->node_name = $_REQUEST['node_name'];
    $payload->parent_node = $_REQUEST['parent_node'];
    $payload->node_type = $_REQUEST['node_type'];

    if($payload->node_type ==''){
        $payload->node_type = 'testplan';
    }

    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/nodes';
    $result = json_decode($cta->httpPostWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
    echo 'Url: '.$url.'<br>Payload : '.json_encode($payload).'<br>Result : '.$result;

    if($result != '201'){
        $_SESSION['addTestplanNodeError'] = $result;
    }

    header("Location:".$_SESSION['site-url']);
    exit();

?>