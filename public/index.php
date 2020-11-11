<?php

use Farid\Framework\Http\Request;

require_once __DIR__ . '/../vendor/autoload.php';

### Initialization

$request = new Request();

### Action

$name = $_GET['name'] ?? 'Guest';
header('X-Developer: Fred');
echo 'Hello, ' . $name . '!';