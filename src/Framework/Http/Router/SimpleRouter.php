<?php

namespace Farid\Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;
use Farid\Framework\Http\Router\Exception\RouteNotFoundException;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;


class SimpleRouter implements Router
{
    public $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }
        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        if (null !== $url = $route->generate($name, array_filter($params))) {
            return $url;
        }

        throw new RouteNotFoundException($name, $params);
    }
}