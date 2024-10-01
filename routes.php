<?php

use Src\Router;

Router::get('/', function () {
    return "Default page";
});

Router::get('/about', function () {
    return "About page";
});

Router::post('/submit', function () {
    return "Form submitted.";
});

return Router::class; 