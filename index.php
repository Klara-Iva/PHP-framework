<?php

require 'vendor/autoload.php';

use Src\Request;
use Src\Router;

$router = require 'routes.php';

$request = new Request();

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/php-framework', '', $url);

$method = $_SERVER['REQUEST_METHOD'];

$content = Router::resolve($url, $method);
$content->send();