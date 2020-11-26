#!/usr/bin/env php
<?php

use Farid\Framework\Console\Input;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require_once __DIR__ . '/../config/container.php';

$command = $container->get(\Farid\App\Console\CacheClearCommand::class);

$input = new Input($argv);

$command->execute($input);