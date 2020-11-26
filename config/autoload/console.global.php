<?php

return [
    'dependencies' => [
        'factories' => [
            \Farid\App\Console\CacheClearCommand::class => \Farid\Framework\Infrastructure\Framework\Console\CacheClearCommandFactory::class,
        ]
    ],
    'console' => [
        'cachePaths' => [
            'log' => 'var/log',
            'db' => 'var/db',
            'twig' => 'var/twig'
        ]
    ]
];