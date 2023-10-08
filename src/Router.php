<?php

namespace SevenCoder\Router;

use CoreLoader;

class Router extends Dispatch
{
    public function __construct(string $projectUrl, ?string $separator = ':')
    {
        parent::__construct($projectUrl, $separator);
    }

    public function post(string $route, string $handler, ?string $name = null): void
    {
        $this->addRoute("POST", $route, $handler, $name);
    }

    public function get(string $route, string $handler, ?string $name = null): void
    {
        $this->addRoute("GET", $route, $handler, $name);
    }

    public function put(string $route, $handler, string $name = null): void
    {
        $this->addRoute("PUT", $route, $handler, $name);
    }

    public function patch(string $route, $handler, string $name = null): void
    {
        $this->addRoute("PATCH", $route, $handler, $name);
    }

    public function options(string $route, $handler, string $name = null): void
    {
        $this->addRoute("OPTIONS", $route, $handler, $name);
    }

    public function delete(string $route, $handler, string $name = null): void
    {
        $this->addRoute("DELETE", $route, $handler, $name);
    }

    public function prefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    public function setBasePath(string $basePath): void
    {
        CoreLoader::setPath($basePath);
    }
}
