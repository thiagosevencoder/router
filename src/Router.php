<?php

namespace SevenCoder\Router;

use CoreLoader;

class Router extends Dispatch
{
    public function __construct(string $projectUrl, ?string $separator = ':')
    {
        parent::__construct($projectUrl, $separator);
    }

    /**
     * @param string $route
     * @param string $handler
     * @param string|null $name
     */
    public function post(string $route, string $handler, ?string $name = null): void
    {
        $this->addRoute("POST", $route, $handler, $name);
    }

    /**
     * @param string $route
     * @param string $handler
     * @param string|null $name
     */
    public function get(string $route, string $handler, ?string $name = null): void
    {
        $this->addRoute("GET", $route, $handler, $name);
    }

    /**
     * @param string $route
     * @param $handler
     * @param string|null $name
     */
    public function put(string $route, $handler, string $name = null): void
    {
        $this->addRoute("PUT", $route, $handler, $name);
    }

    /**
     * @param string $route
     * @param $handler
     * @param string|null $name
     */
    public function patch(string $route, $handler, string $name = null): void
    {
        $this->addRoute("PATCH", $route, $handler, $name);
    }

    /**
     * @param string $route
     * @param $handler
     * @param string|null $name
     */
    public function options(string $route, $handler, string $name = null): void
    {
        $this->addRoute("OPTIONS", $route, $handler, $name);
    }

    /**
     * @param string $route
     * @param $handler
     * @param string|null $name
     */
    public function delete(string $route, $handler, string $name = null): void
    {
        $this->addRoute("DELETE", $route, $handler, $name);
    }

    /**
     * @param string|null $prefix
     */
    public function prefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        CoreLoader::setPath($basePath);
    }
}
