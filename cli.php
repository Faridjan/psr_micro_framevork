<?php

require_once __DIR__ . '/vendor/autoload.php';

$container = require __DIR__ . '/config/container.php';


/**
 * @var \Psr\Container\ContainerInterface $container
 * @var PDO $pdo
 */
$pdo = $container->get(\PDO::class);

$id = 1;

$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$stmt->bindValue(':id', $id, \PDO::PARAM_INT);
$stmt->execute();

print_r($stmt->fetch(\PDO::FETCH_ASSOC));