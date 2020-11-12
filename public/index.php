<?php

use \Farid\Framework\Http\RequestFactory;
use Farid\Framework\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

### Initialization

$request = RequestFactory::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
$response = (new Response('Hello, ' . $name . '!'))
    ->withHeader("X-Developer", 'Fred')
    ->withBody('<h1>Hello Word</h1><hr> <p></p>')
    ->withStatus(500, 'Bad Custom');

header('HTTP/1.0 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());

foreach ($response->getHeaders() as $name => $value) {
    header($name . ':' . $value);
}


echo $response->getBody();
echo '<strong style="font-size: 50px; color: #ff0000">';
echo $response->getStatusCode();
echo '</strong>';
echo $response->getReasonPhrase();