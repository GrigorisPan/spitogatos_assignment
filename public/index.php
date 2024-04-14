<?php
require __DIR__ . '/../vendor/autoload.php';

use Framework\Session;
use Framework\Router;
use Framework\Database;

Session::start();

require '../helpers.php';

$config = require basePath('config/db.php');
$db = new Database($config);

$router = new Router();

//Get routes
$routers = require basePath('routes.php');

//Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Route the request
$router->route($uri);
