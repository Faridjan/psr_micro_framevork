<?php

use App\Test\Test4;
use App\Test\Dispatcher;

use App\Test\ErrorEvent;
use App\Test\SuccessEvent;

require_once __DIR__ . '/vendor/autoload.php';


$test = new Test4();

$test2 = $test;
$test3 = $test->withIdempotent(20);

$test2->setIdemPotent(10);

echo PHP_EOL;

$test3->setIdemPotent(30);

echo $test3->getIdemPotent() . PHP_EOL;
echo $test2->getIdemPotent() . PHP_EOL;
