<?php

require 'vendor/autoload.php';
require 'routes.php';

use Src\Request\Request;
use Src\Routing\Router;

$request = new Request();
$content = Router::resolve($request);
$content->send();