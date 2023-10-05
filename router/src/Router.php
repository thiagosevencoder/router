<?php

namespace Router;

class Router
{
    private array $routes = [];
    private string $projectUrl;
    protected ?string $namespace = null;

    public function __construct(string $projectUrl)
    {
        $this->projectUrl = $projectUrl;
    }

    public function addRoute($url, $controller, $method = 'GET')
    {
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $this->routes[$method][$url] = $controller;
    }

    public function namespace(?string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function handleRequest($url, $method)
    {
        if (isset($this->routes[$method]) && array_key_exists($url, $this->routes[$method])) {
            $controllerInfo = $this->routes[$method][$url];
            list($controllerName, $methodName) = explode('@', $controllerInfo);

            $fullControllerName = "\\".$this->namespace . '\\' . $controllerName;

            if (class_exists($fullControllerName)) {
                $controller = new $fullControllerName();

                // Verifique se o método do controlador existe
                if (method_exists($controller, $methodName)) {
                    // Chame o método do controlador
                    $controller->$methodName();
                } else {
                    echo "Método não encontrado no controlador!";
                }
            } else {
                echo "Controlador não encontrado!";
            }
        } else {
            // Rota não encontrada para este método
            echo "Rota não encontrada para o método $method!";
        }
    }
}
