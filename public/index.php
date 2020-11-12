<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Diactoros\Stream;

require_once __DIR__ . '/../vendor/autoload.php';

### Initialization Request
$request = ServerRequestFactory::fromGlobals();

### Build Request
$path = $request->getUri()->getPath();
$cookies = print_r($request->getCookieParams(), true);

$stream1 = new Stream('php://temp', 'wb+');
$stream1->write('<h1>Hello Word</h1><hr><pre>Cookies:' . $cookies . '</pre>');
$stream1->rewind();

$stream2 = new Stream('php://temp', 'wb+');
$stream2->write('<hr><pre>Get query:' . print_r($request->getQueryParams(), true) . '</pre>');
$stream2->rewind();

if ($path === '/') {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse('Hello, ' . $name);
} elseif ($path === '/about') {
    $response = new HtmlResponse('This is a simple site');
} elseif ($path === '/blog') {
    $response = new JsonResponse([
        ['id' => 1, 'title' => 'First post'],
        ['id' => 2, 'title' => 'Second post']
    ]);
} elseif (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {
    if ($matches['id'] == 1) {
        $response = new JsonResponse(['id' => 1, 'title' => 'First post']);
    } elseif ($matches['id'] == 2) {
        $response = new JsonResponse(['id' => 1, 'title' => 'First post']);
    } else {
        $response = new JsonResponse(['Error' => 'Undefined page'], 400);
    }
} else {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

### Post processing
$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);

### Custom stream
echo '<hr>';
echo '<strong style="font-size: 50px; color: #ff0000">';
echo $response->getStatusCode();
echo '</strong>';
echo $response->getReasonPhrase();