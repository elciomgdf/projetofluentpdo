<?php

namespace App\Traits;

trait RequestTrait
{

    protected array $routeParams = [];

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function getRouteParam(string $key, $default = null)
    {
        return $this->routeParams[$key] ?? $default;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    protected ?array $inputCache = null;

    public function makeBody(): array
    {
        if ($this->inputCache !== null) {
            return $this->inputCache;
        }
        $input = file_get_contents('php://input');
        $json = json_decode($input, true);
        $this->inputCache = array_merge($_POST, is_array($json) ? $json : []);
        return $this->inputCache;
    }

    public function input(string $key, $default = null)
    {
        $data = $this->makeBody();
        return $data[$key] ?? $default;
    }

    public function inputs(): array
    {
        return $this->makeBody();
    }

    public function queryParam(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public function queryParams(): array
    {
        return $_GET;
    }

    public function buildQuery($key, $value): string
    {
        $query = $_GET;
        $query[$key] = $value;
        return '?' . http_build_query($query);
    }

}
