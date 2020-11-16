<?php

namespace Farid\Framework\Http\Router;

use Farid\Framework\Http\Router\Route\Route;
use Farid\Framework\Http\Router\Route\RegexpRoute;

class RouteCollection
{
    private $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add($name, $pattern, $handler, array $methods, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, $methods, $tokens));
    }

    public function get($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens));
    }

    public function post($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens));
    }

    public function anny($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, [], $tokens));
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}