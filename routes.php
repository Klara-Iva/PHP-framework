<?php

use Src\Routing\Route;
use Src\Controller\IndexController;
use Src\Response\JsonResponse;
use Src\Models\User;
use Src\Models\Product;

Route::get('/', function () {
    return "Default page";
});

Route::get('/about', function () {
    return "About page";
});

Route::post('/submit', function () {
    return "Form submitted.";
});

Route::get('/products/{productId}', function ($productId) {
    return "Product ID is: " . $productId;
});

Route::get('/products/{productId}/reviews/{reviewId}', function ($productId, $reviewId) {
    return "Product ID: " . $productId . ", Review ID: " . $reviewId;
});

Route::get('/api/v1/products/{productId}/reviews/{reviewId}', function ($productId, $reviewId) {
    return new JsonResponse([
        'productId' => $productId,
        'reviewId' => $reviewId,
        'message' => "Product ID: $productId, Review ID: $reviewId"
    ]);
});

Route::get('/home', [IndexController::class, 'indexAction']);
Route::get('/home/json', [IndexController::class, 'indexJsonAction']);
Route::get('/home/twig', [IndexController::class, 'indexTwigAction']);

Route::get('/user/create', [User::class, 'create']);
Route::get('/user/{id}', [User::class, 'read']);
Route::get('/user/update/{id}', [User::class, 'update']);
Route::get('/user/delete/{id}', [User::class, 'delete']);

Route::post('/product/create', [Product::class, 'create']);
Route::post('/product/{id}', [Product::class, 'read']);
Route::post('/product/update/{id}', [Product::class, 'update']);
Route::post('/product/delete/{id}', [Product::class, 'delete']);