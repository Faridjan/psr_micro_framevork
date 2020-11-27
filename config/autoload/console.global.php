<?php

return [
    'dependencies' => [
        'factories' => [
            \Farid\App\Console\Command\CacheClearCommand::class => \Farid\Framework\Infrastructure\Framework\Console\CacheClearCommandFactory::class,
        ]
    ],
    'console' => [
        'commands' => [
            \Farid\App\Console\Command\CacheClearCommand::class
        ],
        'cachePaths' => [
            'log' => 'var/log',
            'db' => 'var/db',
            'twig' => 'var/twig'
        ]
    ]
];