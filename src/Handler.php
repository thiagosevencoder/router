<?php

namespace SevenCoder\Router;

trait Handler
{
    private array $routes = [];

    public function addRoute(string $method, string $route, string $handler, ?string $name): void
    {
        if ($route == '/') {
            $this->routes[] = '';
        }

        $processData = new ProcessData($route, $this->httpMethod, $this->patch, $this->prefix);
        $data = $processData->requestProcessData();
        $controller = $this->getController($handler);
        $action = $this->getAction($handler);
        $route = (!$this->prefix ? $route : "{$this->prefix}"."/"."{$route}");

        $router = function () use ($method, $controller, $action, $data, $route, $name) {
            return [
                "route" => $route,
                "name" => $name,
                "method" => $method,
                "data" => $data,
                'controller' => $controller,
                'action' => $action
            ];
        };

        $route = preg_replace('~{([^}]*)}~', "([^/]+)", $route);
        $this->routes[$method][$route] = $router();
    }

    private function getController(string $handler) {
        return (!is_string($handler) ? $handler : explode($this->separator, $handler)[0]);
    }

    private function getAction($handler): ?string
    {
        return (!is_string($handler) ?: (explode($this->separator, $handler)[1] ?? null));
    }
}