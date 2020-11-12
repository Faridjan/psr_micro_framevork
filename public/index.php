<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
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

$action = null;

if ($path === '/') {
    $action = function (ServerRequestInterface $request) {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name);
    };
} elseif ($path === '/about') {
    $action = function () {
        return new HtmlResponse('This is a simple site');
    };
} elseif ($path === '/blog') {
    $action = function () {
        return new JsonResponse([
            ['id' => 1, 'title' => 'First post'],
            ['id' => 2, 'title' => 'Second post']
        ]);
    };
} elseif (preg_match('#^/blog/(?P<id>\d+)$#i', $path, $matches)) {
    $request->withAttribute('id', $matches['id']);
    $action = function (ServerRequestInterface $request) {
        $id = $request->getAttribute('id');
        if ($id == 1) {
            return new JsonResponse(['id' => 1, 'title' => 'First post']);
        } elseif ($id == 2) {
            return new JsonResponse(['id' => 2, 'title' => 'First post']);
        } else {
            return new JsonResponse(['Error' => 'Undefined page'], 400);
        }
    };
}

### Post processing
if ($action) {
    $response = $action($request);
} else {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);

### Custom stream
echo '<hr>';
echo '<strong style="font-size: 50px; color: #ff0000">';
echo $response->getStatusCode();
echo '</strong>';
echo $response->getReasonPhrase();