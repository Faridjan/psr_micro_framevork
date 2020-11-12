<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

require_once __DIR__ . '/../vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
$cookies = print_r($request->getCookieParams(), true);

$response = (new HtmlResponse('<h1>Hello Word</h1><hr><pre>Cookies:' . $cookies . '</pre>'))
    ->withHeader("X-Developer", 'Fred')
    ->withStatus(500, 'Bad Custom');

### Sending

(new SapiEmitter())->emit($response);


echo '<strong style="font-size: 50px; color: #ff0000">';
echo $response->getStatusCode();
echo '</strong>';
echo $response->getReasonPhrase();