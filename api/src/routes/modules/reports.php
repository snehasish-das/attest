<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Group tests by category
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

//Group tests runs by type
$app->get('/reports/test-runs-by-type', function (Request $request, Response $response, array $args) {
    $getReport = "SELECT tn.parent_node, COUNT(tr.test_id) as count FROM `tcm_releases` tr, `tcm_nodes` tn WHERE tn.node_name=tr.parent_node AND tr.is_deleted=0 GROUP BY tn.parent_node";
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

//Last 10 runs
$app->get('/reports/lastest-runs', function (Request $request, Response $response, array $args) {
    $getReport = "SELECT tn.node_name, tn.parent_node, COUNT(test_status) as total, SUM(CASE WHEN test_status='Passed' THEN 1 ELSE 0 END) as passed, SUM(CASE WHEN test_status='Failed' THEN 1 ELSE 0 END) as failed, SUM(CASE WHEN test_status='Not Started' THEN 1 ELSE 0 END) as not_started, tr.test_run_link FROM `tcm_releases` tr, `tcm_nodes` tn WHERE tr.parent_node=tn.node_name GROUP BY tn.node_name ORDER BY tr.execution_date DESC LIMIT 5";
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

//Recents runs
$app->get('/reports/recent-run-dates', function (Request $request, Response $response, array $args) {
    $getReport = "SELECT DISTINCT `execution_date` FROM `tcm_releases` ORDER BY `execution_date` DESC LIMIT 5";
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

//Jira most failures
$app->get('/reports/most-failures', function (Request $request, Response $response, array $args) {
    $execution_date = $request->getParam('execution_date');
    if ($execution_date == '') {
        $execution_date = date('Y-m-d');
    }

    $getReport = "SELECT `execution_date`, `bug_no`, COUNT(test_id) as count, `parent_node` FROM `tcm_releases` WHERE `test_status`='Failed' AND bug_no <> '' AND execution_date='$execution_date' GROUP BY bug_no ORDER BY count DESC, test_id LIMIT 5";
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