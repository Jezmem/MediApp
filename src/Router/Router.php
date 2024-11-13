<?php

namespace App\Router;

class Router
{
    /** @var array<Route>  */
    private array $routes;

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @throws RouteActionNotFoundException
     * @throws RouteNotFoundException
     */
    public function resolve(): string
    {
        foreach ($this->routes as $route) {
            if ($route->getUrl() === strtok($_SERVER["REQUEST_URI"], '?')) {
                $controllerName = $route->getControllerName();
                $instance = new $controllerName();
                $action = $route->getActionName();

                if (!method_exists($instance, $route->getActionName())) {
                    throw new \Exception(sprintf('No route action found to resolve "%s", action "%s" was not found in Controller "%s".', $_SERVER["PATH_INFO"], $route->getActionName(), $route->getControllerName()));
                }

                return $instance->$action();
            }
        }

        throw new \Exception(sprintf('No route action found to resolve url "%s".', $_SERVER['REQUEST_URI']));
    }
}