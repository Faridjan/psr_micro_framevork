<?php

use Aura\Router\RouterContainer;
use Farid\App\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\Framework\Http\Application;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Farid\App\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;


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
            PrettyErrorResponseGenerator::class => function (ContainerInterface $container) {
                return new PrettyErrorResponseGenerator($container->get('config')['debug']);
            },
            ErrorHandlerMiddleware::class => function (ContainerInterface $container) {
                return new ErrorHandlerMiddleware($container->get(PrettyErrorResponseGenerator::class));
            }
        ]
    ],
    'debug' => true
];