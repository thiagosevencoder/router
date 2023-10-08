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

    public function prefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    public function patch(string $route, $handler, string $name = null): void
    {
        $this->addRoute("PATCH", $route, $handler, $name);
    }

    public function setBasePath(string $basePath): void
    {
        CoreLoader::setPath($basePath);
    }
}
