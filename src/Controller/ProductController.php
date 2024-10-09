<?php

namespace Src\Controller;

use Src\Models\Product;
use Src\Request\Request;

class ProductController
{
    public function create(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');

        $data = [
            'name' => $name,
            'description' => $description,
        ];

        foreach ($data as $key => $value) {
            if (empty($value) || !is_string($value)) {
                echo ucfirst($key) . " is mandatory and must be a valid string.";
                return;
            }
        }

        if (empty($price) || !is_numeric($price) || $price < 0) {
            echo "Price is mandatory and must be a non-negative number.";
            return;
        }

        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->save();
        echo "Product created successfully!";
    }

    public function read(string $id)
    {
        if (!$id) {
            echo "ID is required!";
            return;
        }

        $product = Product::find($id);

        if (!$product) {
            echo "Product not found!";
            return;
        }

        echo json_encode($product->toArray());
    }

    public function update(string $id, Request $request)
    {
        if (!$id) {
            echo "ID is required!";
            return;
        }

        $product = Product::find($id);

        if (!$product) {
            echo "Product not found!";
            return;
        }

        $name = $request->get("name") ?? $product->name;
        $description = $request->get("description") ?? $product->description;
        $price = $request->get("price") ?? $product->price;

        if (empty($name) || !is_string($name)) {
            echo "Name is mandatory and must be a valid string.";
            return;
        }

        if (empty($description) || !is_string($description)) {
            echo "Description is mandatory and must be a valid string.";
            return;
        }

        if (empty($price) || !is_numeric($price) || $price < 0) {
            echo "Price is mandatory and must be a non-negative number.";
            return;
        }

        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->save();
        echo "Product updated successfully!";
    }

    public function delete(string $id)
    {
        if (!$id) {
            echo "ID is required!";
            return;
        }

        $product = Product::find($id);

        if (!$product) {
            echo "Product not found!";
            return;
        }

        $product->delete($id);
    }

}