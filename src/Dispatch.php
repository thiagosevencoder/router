<?php

namespace SevenCoder\Router;

require_once('core/CoreLoader.php');

spl_autoload_register('CoreLoader::loader');

class Dispatch
{
    use Handler;

    private string $projectUrl;
    protected string $separator;
    protected string $prefix = '';
    protected ?string $patch;
    protected string $httpMethod;
    private ?array $route;

    public function __construct(string $projectUrl, ?string $separator = ":")
    {
        $this->projectUrl = (substr($projectUrl, "-1") == "/" ? substr($projectUrl, 0, -1) : $projectUrl);
        $this->patch = (filter_input(INPUT_GET, "route", FILTER_DEFAULT) ?? "/");
        $this->separator = ($separator ?? ":");
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function dispatch(): bool
    {
        if (empty($this->routes) || empty($this->routes[$this->httpMethod])) {
            return false;
        }

        $this->route = null;

        foreach ($this->routes[$this->httpMethod] as $key => $route) {

            if (preg_match("~^" . $key . "$~", $this->patch, $found)) {
                $this->route = $route;
            }
        }

        return $this->execute();
    }

    private function execute()
    {
        if ($this->route) {
            if (is_callable($this->route['controller'])) {
                call_user_func($this->route['controller'], ($this->route['data'] ?? []));
                return true;
            }

            $controller = $this->route['controller'];
            $method = $this->route['action'];

            if (class_exists($controller)) {
                $newController = new $controller($this);

                if (method_exists($controller, $method)) {
                    $newController->$method(($this->route['data'] ?? []));
                    return true;
                }
            }

            return false;
        }

        return false;
    }
}