<?php

return [
    'auth' => [
        'users' => ['admin' => 'pass']
    ],
    'pdo' => [
        'dsn' => 'pgsql:host=api-postgres;port=5432;dbname=app',
        'username' => 'app',
        'password' => 'secret'
    ],
    'phinx' => [
        'database' => 'app',
    ]
];