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
            'url'=> $url,
            'method'=> 'POST',
            'callback'=> $callback,
        ];
    }

    public static function resolve(string $url, string $method)
    {
        foreach (self::$routes as $route) {
            if ($route['url'] === $url && $route['method'] === $method) {
                return call_user_func($route['callback']);
            }

        }

        return "404, Not Found.";
    }

}