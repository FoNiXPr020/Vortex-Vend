<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Core\Session;
use Core\Router;
use Core\Functions;
use Core\Translator;
use Dotenv\Dotenv;

const BASE_PATH = __DIR__ . '/../';
const BASE_VIEW = __DIR__ . '/../views/';
const BASE_VIEW_MAIN = __DIR__ . '/../views/resources/';
const BASE_TEMPLATE = __DIR__ . '/../views/templates/';

require BASE_PATH . 'vendor/autoload.php';
require BASE_PATH . 'Core/Base.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

Session::initSession();

$router = new Router();
$functions = new Functions();

$routes = require $functions->base_path('routes.php');

// $uri = rtrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
// $uri = rtrim($uri, '.php');
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$uri = $uri ?: '/';

$method = $_POST[$_ENV['METHOD']] ?? $_SERVER['REQUEST_METHOD'];

$router->Route($uri, $method);

// Unset flash data
Session::unflash();
