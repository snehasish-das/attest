<?php
    session_start();
    $payload = new stdClass();
    $parent_node = $_REQUEST['parent_node'];
    $test_id = $_REQUEST['test_id'];
    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/tests/'. $test_id;
    $result = json_decode($cta->httpDeleteWithAuth($url,$_SESSION['auth-phrase']), true);
    echo 'Url: '.$url.'<br>Result : '.$result;

    if($result != '204'){
        $_SESSION['deleteTestError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/test-plan?node='.$_REQUEST['parent_node'].'&parent_node='.$_REQUEST['ancestor_node']);
    exit();

?>