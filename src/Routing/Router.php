<?php

namespace Src\Routing;

use Src\Routing\Route;
use Src\Request\Request;
use Src\Response\Response;

class Router
{
    public static function resolve(Request $request)
    {
        $routes = Route::getRoutes();
        $url = $request->getUrl();
        $method = $request->getMethod();

        foreach ($routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([0-9]+)', $route['url']);
            if (preg_match('#^' . $pattern . '$#', $url, $matches) && $route['method'] === $method) {
                array_shift($matches);
                $callback = $route['callback'];

                if (is_array($callback)) {
                    $controllerClass = $callback[0];
                    $method = $callback[1];
                    $controller = new $controllerClass();
                    $content = call_user_func_array([$controller, $method], array_merge($matches, [$request]));
                } else {
                    $content = call_user_func_array($callback, $matches);
                }

                return new Response($content);
            }

        }

        return new Response("404, Not Found.");
    }

}