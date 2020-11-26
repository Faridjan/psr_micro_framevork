#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require_once __DIR__ . '/../config/container.php';

$command = $container->get(\Farid\App\Console\CacheClearCommand::class);

$command->execute(array_slice($argv, 1));