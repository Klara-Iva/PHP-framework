<?php

require 'vendor/autoload.php';

use Src\Request;
use Src\Response;

$router = require 'routes.php';

$request = new Request($_GET, $_POST);

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/php-framework', '', $url);

$method = $_SERVER['REQUEST_METHOD'];

$content = $router->resolve($url, $method);

$response = new Response($content);

echo $response->send();