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

$cli->getHelperSet()->set(new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
    $container->get(\Doctrine\ORM\EntityManagerInterface::class)
), 'em');

\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);

$cli->run();