<?php


require __DIR__ . '/vendor/autoload.php';

/**
 * @var \Psr\Container\ContainerInterface $container
 */

$container = require __DIR__ . '/config/container.php';

return new \Symfony\Component\Console\Helper\HelperSet([
    new \Symfony\Component\Console\Helper\FormatterHelper(),
    new \Symfony\Component\Console\Helper\DebugFormatterHelper(),
    new \Symfony\Component\Console\Helper\ProcessHelper(),
    new \Symfony\Component\Console\Helper\QuestionHelper(),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
        $container->get(\Doctrine\ORM\EntityManagerInterface::class)
    )
]);
