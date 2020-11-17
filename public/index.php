<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Aura\Router\RouterContainer;
use Farid\Framework\Http\Pipeline\Pipeline;

use Farid\App\Http\Middleware\BasicAuthMiddleware;
use Farid\App\Http\Middleware\ProfileMiddleware;
use Farid\App\Http\Middleware\NotFoundHandler;

use Farid\App\Http\Action\HelloAction;
use Farid\App\Http\Action\AboutAction;
use Farid\App\Http\Action\Blog\IndexAction;
use Farid\App\Http\Action\Blog\ShowAction;
use Farid\App\Http\Action\CabinetAction;

require_once __DIR__ . '/../vendor/autoload.php';

### REQUEST
$request = ServerRequestFactory::fromGlobals();

$params = [
    'users' => ['admin' => 'password'],
];

### ROUTE COLLECTION / ACTIONS
$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', HelloAction::class);
$routes->get('about', '/about', AboutAction::class);

$routes->get('cabinet', '/cabinet', [
    ProfileMiddleware::class,
    new BasicAuthMiddleware($params['users']),
    CabinetAction::class,
]);

$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(["id" => "\d+"]);

### ROUTING
$router = new AuraRouterAdapter($aura);
$resolver = new MiddlewareResolver();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handlers = $result->getHandler();

    $pipeline = new Pipeline();

    foreach (is_array($handlers) ? $handlers : [$handlers] as $handler) {
        $pipeline->pipe($resolver->resolve($handler));
    }
    $response = $pipeline($request, new NotFoundHandler());
} catch (RequestNotMatchedException $e) {
    $handler = new NotFoundHandler();
    $response = $handler($request);
}

### Post processing
$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);