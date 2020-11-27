#!/usr/bin/env php
<?php

use Farid\App\Console\CacheClearCommand;
use Farid\Framework\Console\Input;
use Farid\Framework\Console\Output;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require_once __DIR__ . '/../config/container.php';

$cli = new \Farid\Framework\Console\Application();
$cli->add($container->get(CacheClearCommand::class));
$cli->add($container->get(CacheClearCommand::class));
$cli->add($container->get(CacheClearCommand::class));
$cli->add($container->get(CacheClearCommand::class));
$cli->add($container->get(CacheClearCommand::class));
$cli->run(new Input($argv), new Output());

//while (true) {
//    echo "Hello \033[36mAGAIN\033[0m!\n";
//    sleep(0.25);
//    echo "\033[10;500;11;1000]\7";
//    $i++;
//}

