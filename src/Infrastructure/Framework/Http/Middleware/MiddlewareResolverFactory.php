<?php

namespace Farid\Infrastructure\Framework\Http\Middleware;

use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class MiddlewareResolverFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MiddlewareResolver($container, new Response());
    }
}
