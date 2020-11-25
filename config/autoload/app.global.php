<?php

use Farid\Framework\Http\Application;
use Farid\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\Router;
use Farid\Framework\Infrastructure\App\Logger\LoggerFactory;
use Farid\Framework\Infrastructure\Framework\Http\ApplicationFactory;
use Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Farid\Framework\Infrastructure\Framework\Http\Middleware\MiddlewareResolverFactory;
use Farid\Framework\Infrastructure\Framework\Http\Router\RouterFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;


/**
 * @var ContainerInterface $container
 */

return [
    'dependencies' => [
        'abstract_factories' => [
            Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            Router::class => RouterFactory::class,
            MiddlewareResolver::class => MiddlewareResolverFactory::class,
            ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
            LoggerInterface::class => LoggerFactory::class,

        ]
    ],
    'debug' => false,
    'config_cache_enabled' => true
];