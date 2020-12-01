<?php

return [
    'dependencies' => [
        'factories' => [
            \Farid\App\Console\Command\CacheClearCommand::class => \Farid\Infrastructure\Framework\Console\CacheClearCommandFactory::class,
            Doctrine\Migrations\Tools\Console\Command\DiffCommand::class => Farid\Infrastructure\App\Doctrine\Factory\DiffCommandFactory::class,
        ]
    ],
    'console' => [
        'commands' => [
            \Farid\App\Console\Command\CacheClearCommand::class,
            Doctrine\Migrations\Tools\Console\Command\ExecuteCommand::class,
            Doctrine\Migrations\Tools\Console\Command\GenerateCommand::class,
            Doctrine\Migrations\Tools\Console\Command\LatestCommand::class,
            Doctrine\Migrations\Tools\Console\Command\MigrateCommand::class,
            Doctrine\Migrations\Tools\Console\Command\DiffCommand::class,
            Doctrine\Migrations\Tools\Console\Command\UpToDateCommand::class,
            Doctrine\Migrations\Tools\Console\Command\StatusCommand::class,
            Doctrine\Migrations\Tools\Console\Command\VersionCommand::class,
        ],
        'cachePaths' => [
            'log' => 'var/log',
            'db' => 'var/db',
            'twig' => 'var/twig'
        ]
    ]
];