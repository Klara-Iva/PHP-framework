<?php

namespace Src\Models;

class Product extends Model
{
    protected $table = 'products';

    public function create()
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? null;
            $description = $data['description'] ?? null;
            $price = $data['price'] ?? null;
        } else {//TODO check for urlencoded
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;
            $price = $_POST['price'] ?? null;
        }
        
        //TODO add null checks
        if ($name && $description && $price) {
            $product = new Product();
            $product->name = $name;
            $product->description = $description;
            $product->price = $price;
            $product->save();
            echo "Product created successfully!";
        } else {
            echo "Some of the parameters are missing!";
        }

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

    public function update(string $id)
    {
        $this->id = $id;
        if ($id) {
            $product = Product::find($id);
            if ($product) {
                $product->name = $_POST['name'] ?? $product->name;
                $product->description = $_POST['description'] ?? $product->description;
                $product->price = $_POST['price'] ?? $product->price;
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
                echo "Product deleted successfully!";
            } else {
                echo "Product not found!";
            }

        } else {
            echo "ID is required!";
        }

    }

}