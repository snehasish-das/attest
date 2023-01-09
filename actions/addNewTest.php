<?php
    session_start();
    $payload = new stdClass();
    $payload->parent_node = $_REQUEST['parent_node'];
    $payload->name = $_REQUEST['name'];
    $payload->product = $_REQUEST['product'];
    $payload->test_type = $_REQUEST['test_type'];
    $payload->priority = $_REQUEST['priority'];
    $payload->automation_status = $_REQUEST['automation_status'];
    $payload->scrum_name = $_REQUEST['scrum_name'];
    $payload->description = $_REQUEST['description'];

    if($payload->node_type ==''){
        $payload->node_type = 'testplan';
    }

    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/tests';
    $result = json_decode($cta->httpPostWithAuth($url,json_encode($payload),$_SESSION['auth-phrase']), true);
    echo 'Url: '.$url.'<br>Payload : '.json_encode($payload).'<br>Result : '.$result;

    if($result != '201'){
        $_SESSION['addTestplanNodeError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/test-plan?node='.$_REQUEST['parent_node']);
    exit();

?>