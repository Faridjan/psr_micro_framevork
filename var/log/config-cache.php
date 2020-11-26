<?php

/**
 * This configuration cache file was generated by Laminas\ConfigAggregator\ConfigAggregator
 * at 2020-11-25T12:12:31+00:00
 */
return [
    'dependencies' => [
        'abstract_factories' => [
            'Laminas\\ServiceManager\\AbstractFactory\\ReflectionBasedAbstractFactory'
        ],
        'factories' => [
            'Farid\\Framework\\Http\\Application' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\ApplicationFactory',
            'Farid\\Framework\\Http\\Router\\Router' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\Router\\RouterFactory',
            'Farid\\Framework\\Http\\Pipeline\\MiddlewareResolver' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\Middleware\\MiddlewareResolverFactory',
            'Farid\\Framework\\Http\\Middleware\\ErrorHandler\\ErrorHandlerMiddleware' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\Middleware\\ErrorHandler\\ErrorHandlerMiddlewareFactory',
            'Psr\\Log\\LoggerInterface' => 'Farid\\Framework\\Infrastructure\\App\\Logger\\LoggerFactory',
            'Farid\\App\\Http\\Middleware\\BasicAuthMiddleware' => function (\Psr\Container\ContainerInterface $container) {
                return new \Farid\App\Http\Middleware\BasicAuthMiddleware($container->get('config')['users']);
            },
            'Farid\\Framework\\Http\\Middleware\\ErrorHandler\\ErrorResponseGenerator' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\Middleware\\ErrorHandler\\PrettyErrorResponseGeneratorFactory',
            'Whoops\\RunInterface' => 'Farid\\Framework\\Infrastructure\\Framework\\Http\\Middleware\\ErrorHandler\\WhoopsRunFactory'
        ]
    ],
    'debug' => true,
    'config_cache_enabled' => true,
    'users' => [
        'admin' => 'pass'
    ]
];
