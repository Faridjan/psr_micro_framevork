<?php

require __DIR__ . '/vendor/autoload.php';

$container = require __DIR__ . '/config/container.php';

return [
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'app',
        'app' => [
            'name' => $container->get('config')['phinx']['database'],
            'connection' => $container->get(PDO::class),
        ],
    ],
    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
        'seeds' => __DIR__ . '/db/seeds'
    ],
];
