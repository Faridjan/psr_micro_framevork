<?php

use Aura\Router\RouterContainer;
use Farid\App\Http\Middleware\ErrorHandlerMiddleware;
use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\Framework\Http\Application;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;


/**
 * @var ContainerInterface $container
 */

return [
    'dependencies' => [
        'abstract_factories' => [
            Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    new NotFoundHandler(),
                    new Response()
                );
            },
            Router::class => function () {
                return new AuraRouterAdapter(new RouterContainer());
            },
            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container, new Response());
            },
            ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new ErrorHandlerMiddleware($container->get('config')['debug']);
            }
        ]
    ],
    'debug' => true
];