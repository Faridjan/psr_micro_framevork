<?php

/**
 * @var ContainerInterface $container
 */

use Farid\Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory;
use Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler\WhoopsRunFactory;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            ErrorResponseGenerator::class => PrettyErrorResponseGeneratorFactory::class,
            Whoops\RunInterface::class => WhoopsRunFactory::class,


        ]
    ],
    'debug' => true
];