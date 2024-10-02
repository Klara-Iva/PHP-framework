<?php

namespace Src;

class Router
{
    public static function resolve(string $url, string $method)
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([0-9]+)', $route['url']);
            if (preg_match('#^' . $pattern . '$#', $url, $matches) && $route['method'] === $method) {
                array_shift($matches);
                $callback = $route['callback'];

                if (is_array($callback)) {
                    $controllerClass = $callback[0];
                    $method = $callback[1];
                    $controller = new $controllerClass();
                    $content = call_user_func_array([$controller, $method], $matches);
                } else {
                    $content = call_user_func_array($callback, $matches);
                }

                if ($content instanceof JsonResponse) {
                    return $content;
                }
                else{
                    return new Response($content);
                }
            }

        }

        return new Response("404, Not Found.");
    }

}