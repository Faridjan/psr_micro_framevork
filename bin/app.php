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


$commands = [
    $container->get(CacheClearCommand::class)
];

$input = new Input($argv);
$output = new Output();
$name = $input->getArguments(0);

/**
 * @var CacheClearCommand $command
 */

if (!empty($name)) {
    foreach ($commands as $command) {
        if ($command->getName() === $name) {
            $command->execute($input, $output);
            exit;
        }
    }
    throw new InvalidArgumentException('Undefined command ' . $name);
}

$output->writeIn('<comment>Available commands:</comment>');
foreach ($commands as $command) {
    $output->writeIn('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
}
$output->writeIn('');

//while (true) {
//    echo "Hello \033[36mAGAIN\033[0m!\n";
//    sleep(0.25);
//    echo "\033[10;500;11;1000]\7";
//    $i++;
//}