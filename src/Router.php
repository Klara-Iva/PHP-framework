<?php

namespace Src;

class Router
{
    private $routes = [];

    public function addRoute(string $url, string $method, callable $callback)
    {
        $this->routes[] = [
            'url' => $url,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    public function resolve(string $url, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['url'] === $url && $route['method'] === $method) {
                return $route['callback']();
            }

        }

        return "404, Not Found.";
    }

}