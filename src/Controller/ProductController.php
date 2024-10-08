<?php

namespace Src\Controller;

use Src\Models\Product;
use Src\Request\Request;

class ProductController
{
    public function create(Request $request)
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? null;
            $description = $data['description'] ?? null;
            $price = $data['price'] ?? null;
        } elseif (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
            $name = $request->post('name') ?? null;
            $description = $request->post('description') ?? null;
            $price = $request->post('price') ?? null;
        } else {
            echo "Unsupported content type.";
            return;
        }

        if (empty($name)) {
            echo "Name is mandatory.";
            return;
        }

        if (!is_string($name)) {
            echo "Name must be a string.";
            return;
        }

        if (empty($description)) {
            echo "Description is mandatory.";
            return;
        }

        if (!is_string($description)) {
            echo "Description must be a string.";
            return;
        }

        if (empty($price)) {
            echo "Price is mandatory.";
            return;
        }

        if (!is_numeric($price) || $price < 0) {
            echo "Price must be a non-negative number.";
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
        if ($id) {
            $product = Product::find($id);
            if ($product) {
                echo json_encode($product->toArray());
            } else {
                echo "Product not found!";
            }

        } else {
            echo "ID is required!";
        }

    }

    public function update(string $id, Request $request)
    {
        $this->id = $id;
        if ($id) {
            $product = Product::find($id);
            if ($product) {
                $product->name = $request->post("name") ?? $product->name;
                $product->description = $request->post("description") ?? $product->description;
                $product->price = $request->post("price") ?? $product->price;
                $product->save();
                echo "Product updated successfully!";
            } else {
                echo "Product not found!";
            }

        } else {
            echo "ID is required!";
        }

    }

    public function delete(string $id)
    {
        if ($id) {
            $product = Product::find($id);
            if ($product) {
                $product->delete($id);
            } else {
                echo "Product not found!";
            }

        } else {
            echo "ID is required!";
        }

    }
}