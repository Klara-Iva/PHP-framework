<?php

require_once 'vendor\autoload.php'; 

use Src\Models\Product;

$product = new Product();
$product->name = 'Product 404';
$product->description = 'Product is missing from area 11';
$product->price = 9.99;
$array = $product->toArray();
$product->save();
$product = new Product();
$product->name = 'Product 200';
$product->description = 'Product is still in area 11';
$product->price = 11;
$array = $product->toArray();
$product->save();