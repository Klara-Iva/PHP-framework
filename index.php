<?php

require 'vendor/autoload.php';

use Src\Request;
use Src\Response;
use Src\Router;
use Src\JsonResponse;

$router = require 'routes.php';

$request = new Request($_GET, $_POST);

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/php-framework', '', $url);

$method = $_SERVER['REQUEST_METHOD'];

$content = Router::resolve($url, $method);
if ($content instanceof JsonResponse) {
    echo $content->send();
} else {
    $response = new Response($content);
    echo $response->send();
}