<?php

use Aura\Router\RouterContainer;
use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\App\Http\Middleware\ResponseLoggerMiddleware;
use Farid\Framework\Http\Application;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Farid\Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Router;
use Farid\Framework\Infrastucture\Framework\Http\Middleware\ErrorHandler\LogErrorListener;
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
                $middleware = new ErrorHandlerMiddleware(
                    $container->get(ErrorResponseGenerator::class)
                );
                $middleware->addListener($container->get(LogErrorListener::class));
                return $middleware;
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
            },
            Psr\Log\LoggerInterface::class => function (ContainerInterface $container) {
                $logger = new Monolog\Logger('App');
                $logger->pushHandler(new Monolog\Handler\StreamHandler(
                    'var/log/application.log',
                    $container->get('config')['debug'] ? Monolog\Logger::DEBUG : Monolog\Logger::WARNING
                ));
                return $logger;
            },

        ]
    ],
    'debug' => true
];