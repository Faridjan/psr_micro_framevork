<?php

namespace Farid\Infrastructure\Framework\Http;

use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\Framework\Http\Application;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(Router::class),
            new NotFoundHandler(),
            new Response()
        );
    }
}
