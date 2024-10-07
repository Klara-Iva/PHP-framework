<?php

require_once 'vendor\autoload.php'; 

use Src\Models\Product;

$product = new Product();
$product->name = 'Product 404';
$product->description = 'Product is missing from area 11';
$product->price = 9.99;
$array = $product->toArray();
$product->save();
$array = $product->toArray();
$product = Product::find(1);