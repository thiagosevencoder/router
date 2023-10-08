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

        preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $route, $keys, PREG_SET_ORDER);
        $routeDiff = array_values(array_diff(explode("/", $this->patch), explode("/", $route)));

        $this->formSpoofing();
        $offset = ($this->prefix ? 1 : 0);
        foreach ($keys as $key) {
            $this->data[$key[1]] = ($routeDiff[$offset++] ?? null);
        }

        $route = (!$this->prefix ? $route : "{$this->prefix}"."/"."{$route}");
        $data = $this->data;
        $controller = $this->getController($handler);
        $action = $this->getAction($handler);

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