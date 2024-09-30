<?php

use Src\Router;

$router = new Router();

$router->addRoute('/', 'GET', function() {
    return "Deafult page";
});

$router->addRoute('/about', 'GET', function() {
    return "About page";
});

return $router;
