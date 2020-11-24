<?php

namespace Farid\Framework\Http\Router;

use Aura\Router\Exception\RouteNotFound;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;
use Farid\Framework\Http\Router\Exception\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements Router
{
    private $aura;

    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();
        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate($name, array $params = []): string
    {
        $generator = $this->aura->getGenerator();
        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
    }

    public function addRouter(RouteData $data): void
    {
        $map = $this->aura->getMap();

        $route = new Route();
        $route->name($data->name);
        $route->path($data->path);
        $route->handler($data->handler);

        foreach ($data->options as $key => $value) {
            switch ($key) {
                case 'tokens':
                    $route->tokens($value);
                    break;
                case 'defaults':
                    $route->defaults($value);
                    break;
                case 'wildcard':
                    $route->wildcard($value);
                    break;
                default:
                    throw new \InvalidArgumentException('Undefined option "' . $key . '"');
            }
        }

        if ($data->methods) {
            $route->allows($data->methods);
        }

        $map->addRoute($route);
    }
}