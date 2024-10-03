<?php

namespace Src\Routing;


class Route
{
    private static $routes = []; 

    public static function get(string $url, callable | array $callback)
    {
        self::addRoute('GET', $url, $callback);
    }

    public static function post(string $url, callable | array $callback)
    {
        self::addRoute('POST', $url, $callback);
    }

    private static function addRoute($method, $url, $callback)
    {
        self::$routes[] = [
            'url' => $url,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    public static function getRoutes()
    {
        return self::$routes; 
    }

}