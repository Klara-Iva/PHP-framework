<?php

require_once 'vendor\autoload.php'; 

use Src\Models\Product;

$user = new Product();
$user->name = 'Product 1';
$array = $user->toArray();
$user->save();
$array = $user->toArray();
$user = Product::find(1);
$user->name = 'Product 2';
$user->update(1);