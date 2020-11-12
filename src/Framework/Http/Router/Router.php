<?php

namespace Farid\Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

class Router
{
    public $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {

        }
    }

    public function generate()
    {

    }
}