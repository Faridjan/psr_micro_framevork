<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Diactoros\Stream;

require_once __DIR__ . '/../vendor/autoload.php';

### Initialization Request
$request = ServerRequestFactory::fromGlobals();

### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';
$cookies = print_r($request->getCookieParams(), true);

$stream1 = new Stream('php://temp', 'wb+');
$stream1->write('<h1>Hello Word</h1><hr><pre>Cookies:' . $cookies . '</pre>');
$stream1->rewind();

$stream2 = new Stream('php://temp', 'wb+');
$stream2->write('<hr><pre>Get query:' . print_r($request->getUri()->getPath(), true) . '</pre>');
$stream2->rewind();

### Initialization Response

$response = (new HtmlResponse(''))
    ->withHeader("X-Developer", 'Fred')
    ->withStatus(500, 'Bad Custom')
    ->withBody($stream1)
    ->withBody($stream2);


### Sending
(new SapiEmitter())->emit($response);

### Custom stream
echo '<strong style="font-size: 50px; color: #ff0000">';
echo $response->getStatusCode();
echo '</strong>';
echo $response->getReasonPhrase();