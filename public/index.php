<?php

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Router\Router;
use Farid\Framework\Http\Router\RouteCollection;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;


require_once __DIR__ . '/../vendor/autoload.php';

### REQUEST
$request = ServerRequestFactory::fromGlobals();


### ROUTE COLLECTION / ACTIONS
$routes = new RouteCollection();

$routes->get('home', '/', new \Farid\App\Http\Action\HelloAction());
$routes->get('about', '/about', new \Farid\App\Http\Action\AboutAction());
$routes->get('blog', '/blog', new \Farid\App\Http\Action\Blog\IndexAction());
$routes->get('blog_show', '/blog/{id}', new \Farid\App\Http\Action\Blog\ShowAction(), ["id" => "\d+"]);

### ROUTING
$router = new Router($routes);

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $result->getHandler();
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => 'Undefined page'], 404);
}

### Post processing
$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);
