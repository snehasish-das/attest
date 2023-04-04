<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Get
$app->get('/reports/tests-by-category', function (Request $request, Response $response, array $args) {
    $getReport = "SELECT `test_category`, COUNT(*) as `count` FROM `tcm_tests` WHERE `is_deleted`=0 GROUP by `test_category`";
    //echo 'Query : '.$getReport;
    try {
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($getReport);
        $report = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $response->withStatus(200)->write(json_encode($report));
    } catch (PDOException $e) {
        return $response->withStatus(400)->write('{"error" : {"text": ' . $e->getMessage() . '}}');
    }
    $db = null;
})->add(new UserMiddleware());