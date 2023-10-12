<?php

namespace SevenCoder\Router;

class ProcessData
{
    private array $data = [];
    private ?string $httpMethod;
    private ?string $patch;
    private string $route;
    private ?string $prefix;

    public function __construct($route, $httpMethod, $patch, $prefix)
    {
        $this->httpMethod = $httpMethod;
        $this->patch = $patch;
        $this->route = $route;
        $this->prefix = $prefix;
    }

    /**
     * @return array
     */
    public function requestProcessData(): array
    {
        switch ($this->httpMethod) {
            case 'POST':
                $this->data = $this->processPostData();
                return $this->data;
            case 'GET':
                $this->data = $this->processGetData();
                return $this->data;
            case 'PUT':
                $this->data = $this->processHttpBody();
                return $this->data;
            case 'PATCH':
                $this->data = $this->processHttpBody();
                return $this->data;
            case 'DELETE':
                $this->data = $this->processHttpBody();
                return $this->data;
            case 'OPTIONS':
                $this->data = $this->processHttpBody();
                return $this->data;
            default:
                return $this->data;
        }
    }

    private function processPostData(): array
    {
        $dataRequest = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (empty($dataRequest)) {
           $dataRequest = $this->processHttpBody();
        }

        unset($dataRequest["_method"]);
        return $dataRequest;
    }

    private function processHttpBody(): array
    {
        $dataRequest = file_get_contents('php://input', false, null, 0, $_SERVER['CONTENT_LENGTH']);
        $dataRequest = json_decode($dataRequest, true);

        return $dataRequest;
    }

    private function processGetData(): array
    {
        preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $this->route, $keys, PREG_SET_ORDER);
        $routeDiff = array_values(array_diff(explode("/", $this->patch), explode("/", $this->route)));

        $offset = ($this->prefix ? 1 : 0);
        foreach ($keys as $key) {
            $this->data[$key[1]] = ($routeDiff[$offset++] ?? null);
        }

        return $this->data;
    }
}