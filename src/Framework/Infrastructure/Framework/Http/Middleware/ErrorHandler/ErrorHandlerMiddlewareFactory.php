<?php

namespace Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Farid\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Psr\Container\ContainerInterface;

class ErrorHandlerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $middleware = new ErrorHandlerMiddleware(
            $container->get(ErrorResponseGenerator::class)
        );
        $middleware->addListener($container->get(LogErrorListener::class));
        return $middleware;
    }
}
