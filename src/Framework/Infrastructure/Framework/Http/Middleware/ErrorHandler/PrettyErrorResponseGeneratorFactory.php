<?php

namespace Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Farid\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Whoops\RunInterface;

class PrettyErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        if ($container->get('config')['debug']) {
            return new WhoopsErrorResponseGenerator(
                $container->get(RunInterface::class),
                new Response()
            );
        }
        return new PrettyErrorResponseGenerator(new Response());
    }
}
