<?php

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Router\Router;
use Farid\Framework\Http\Router\RouteCollection;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;

use Farid\App\Http\Action\HelloAction;
use Farid\App\Http\Action\AboutAction;
use Farid\App\Http\Action\Blog\IndexAction;
use Farid\App\Http\Action\Blog\ShowAction;

require_once __DIR__ . '/../vendor/autoload.php';

### REQUEST
$request = ServerRequestFactory::fromGlobals();


### ROUTE COLLECTION / ACTIONS
$routes = new RouteCollection();

$routes->get('home', '/', HelloAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class, ["id" => "\d+"]);

### ROUTING
$router = new Router($routes);

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $result->getHandler();
    $action = is_string($handler) ? new $handler() : $handler;
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

### Post processing
$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);
