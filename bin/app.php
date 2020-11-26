#!/usr/bin/env php
<?php

use Farid\Framework\Console\Input;
use Farid\Framework\Console\Output;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = require_once __DIR__ . '/../config/container.php';

$command = $container->get(\Farid\App\Console\CacheClearCommand::class);

$input = new Input($argv);
$output = new Output();

$command->execute($input, $output);

//echo "Hello Fred! \n";
//echo "Hello \033[31mAGAIN\033[0m!\n";
//echo "Hello \033[32mAGAIN\033[0m!\n";
//echo "Hello \033[33mAGAIN\033[0m!\n";
//echo "Hello \033[34mAGAIN\033[0m!\n";
//echo "Hello \033[35mAGAIN\033[0m!\n";
//echo "Hello \033[36mAGAIN\033[0m!\n";

//while (true) {
//    echo "Hello \033[36mAGAIN\033[0m!\n";
//    sleep(0.25);
//    echo "\033[10;500;11;1000]\7";
//    $i++;
//}