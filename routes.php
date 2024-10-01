<?php

use Src\Router;
use Src\JsonResponse;
use Src\IndexController;
use Src\Twig;

$twig = new Twig('templates');

$controller = new IndexController($twig);

Router::get('/', function () {
    return "Default page";
});

Router::get('/about', function () {
    return "About page";
});

Router::post('/submit', function () {
    return "Form submitted.";
});

//using only one placeholder
Router::get('/products/{productId}', function ($productId) {
    return "Product ID is: " . $productId;
});

//using multiple placeholders
Router::get('/products/{productId}/reviews/{reviewId}', function ($productId, $reviewId) {
    return "Product ID: " . $productId . ", Review ID: " . $reviewId;
});

//using multiple placeholders with JSON response
Router::get('/api/v1/products/{productId}/reviews/{reviewId}', function ($productId, $reviewId) {
    return new JsonResponse([
        'productId' => $productId,
        'reviewId' => $reviewId,
        'message' => "Product ID: $productId, Review ID: $reviewId"
    ]);
});

//using controller with only string response
Router::get('/home', [$controller, 'indexAction']);

//using controller with JSON response
Router::get('/home/json', [$controller, 'indexJsonAction']);

//using controller with twig-html reponse
Router::get('/home/twig', [$controller, 'indexTwigAction']);

return Router::class;