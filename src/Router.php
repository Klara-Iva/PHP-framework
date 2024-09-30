<?php

namespace Src;

class Router {
    private $routes = [];

    public function addRoute($url, $method, $callback) {
        $this->routes[] = [
            'url' => $url,
            'method' => $method,
            'callback' => $callback,
        ];
    }
    public function resolve($url, $method) {
          foreach ($this->routes as $route) {
               if ($route['url'] === $url && $route['method'] === $method) {
                return $route['callback']();
            }
        }
        return "404, Not Found."; 
    }
    
    
    
}
