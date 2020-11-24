<?php

use Aura\Router\RouterContainer;
use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\Framework\Http\Application;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Farid\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Router;
use Farid\Framework\Infrastucture\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;
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
                return new ErrorHandlerMiddleware($container->get(ErrorResponseGenerator::class));
            },
            ErrorResponseGenerator::class => function (ContainerInterface $container) {
                if ($container->get('config')['debug']) {
                    return new WhoopsErrorResponseGenerator(
                        $container->get(Whoops\RunInterface::class),
                        new Response()
                    );
                }
                return new PrettyErrorResponseGenerator(new Response());
            },
            Whoops\RunInterface::class => function (ContainerInterface $container) {
                $whoops = new Whoops\Run();
                $whoops->writeToOutput(false);
                $whoops->allowQuit(false);
                $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
                $whoops->register();
                return $whoops;
            }
        ]
    ],
    'debug' => true
];