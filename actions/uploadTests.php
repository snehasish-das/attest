<?php
    session_start();
    //$payload = new stdClass();
    $node = $_REQUEST['parent_node'];
    $product = $_REQUEST['ancestor_node'];
    //$payload->uploadFile = $_FILES['uploadFile']['name'];
    $file=$_FILES['uploadFile']['tmp_name'];
    $csvLines = file($_FILES['uploadFile']['tmp_name'], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    $indexes = str_getcsv(array_shift($csvLines)); 
    $array = array_map(function ($e) use ($indexes) {
        //echo 'Length of headers:'. sizeof($indexes) . 'Length of data:'. sizeof(str_getcsv($e));
        return array_combine($indexes, str_getcsv($e)); 
    }, $csvLines);
    $jsonPayload = json_encode($array);
    //echo $jsonPayload;

    // if($payload->node_type ==''){
    //     $payload->node_type = 'testplan';
    // }

    require_once '../api/src/functions.php';

    $cta = new CallToAction();
    $url = $_SESSION['site-url'] . '/api/upload-tests/'. $product .'/'. $node;
    $result = json_decode($cta->httpPostWithAuth($url,$jsonPayload,$_SESSION['auth-phrase']), true);
    //echo 'Url: '.$url.'<br>Payload : '.json_encode($jsonPayload).'<br>Result : '.$result;

    if($result != '200'){
        $_SESSION['addTestplanNodeError'] = $result;
    }

    header("Location:".$_SESSION['site-url'].'/test-plan?node='.$node.'&parent_node='.$product);
    exit();

?>