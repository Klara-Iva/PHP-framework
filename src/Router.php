<?php

namespace Src;

class Router
{
    private static $routes = [];

    public static function get(string $url, callable $callback)
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'GET',
            'callback' => $callback,
        ];
    }

    public static function post(string $url, callable $callback)
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'POST',
            'callback' => $callback,
        ];
    }

    public static function resolve(string $url, string $method)
    {
        foreach (self::$routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([0-9]+)', $route['url']);
            if (preg_match('#^' . $pattern . '$#', $url, $matches) && $route['method'] === $method) {
                array_shift($matches);
                return call_user_func_array($route['callback'], $matches);
            } 

        }

        return "404, Not Found.";
    }

}