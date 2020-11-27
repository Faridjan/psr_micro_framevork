#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require_once __DIR__ . '/../config/container.php';

$cli = new Application('Application console');

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();

//while (true) {
//    echo "Hello \033[36mAGAIN\033[0m!\n";
//    sleep(0.25);
//    echo "\033[10;500;11;1000]\7";
//    $i++;
//}

