<?php
namespace App\Router;

class Route
{
    private string $url;
    private string $controllerName;
    private string $actionName;
    private string $method;

    public function __construct(string $url, string $controllerName, string $actionName, string $method = 'GET')
    {
        $this->url = $url;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->method = strtoupper($method);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
