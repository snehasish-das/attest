<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//session_start();
require 'vendor/autoload.php';
require 'src/config/db.php';
// error_reporting(-1);
// ini_set('display_errors', 1);


$app = new \Slim\App;


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});


//Middleware
require 'src/routes/site_options.php';
require 'src/routes/middleware/UserMiddleware.php';

//Modules
require 'src/routes/modules/users.php';
require 'src/routes/modules/nodes.php';
require 'src/routes/modules/tests.php';
require 'src/routes/modules/releases.php';
require 'src/routes/modules/features.php';

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Content-type', 'application/json');
});

$app->run();
?>