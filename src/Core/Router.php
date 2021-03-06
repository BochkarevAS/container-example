<?php

namespace Example\Core;

use Example\Middleware\AuthMiddleware;
use Example\Middleware\ShowMiddleware;

class Router {

    private $routes = [];

    private $container;

    public function __construct(Container $container, $routes) {
        $this->container = $container;
        $this->routes = $routes;
    }

    public function run() {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $callable) {

            if (preg_match("~^$route$~", $uri, $matches)) {

                if (in_array($uri, ['security/registration', 'security/login'])) {
                    $middleware = $this->container->make(AuthMiddleware::class);
                    $middleware->handle();
                }

                if (preg_match("~^admin/show/([0-9]+)$~", $uri)) {
                    $middleware = $this->container->make(ShowMiddleware::class);
                    $middleware->handle();
                }

                $callable[0] = $this->container->make($callable[0]);
                $matches[] = $this->container->make(Request::class); // Для того чтобы последний параметр был типа Request
                unset($matches[0]); // Убераю от туда путь ...

                return call_user_func_array($callable, $matches);
            }
        }

        throw new \HttpException('Not found', 404);
    }
}