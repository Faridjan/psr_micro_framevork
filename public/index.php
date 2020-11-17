<?php

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;
use Farid\Framework\Http\ActionResolver;
use Aura\Router\RouterContainer;
use Psr\Http\Message\ServerRequestInterface;

use Farid\App\Http\Middleware\BasicAuthMiddleware;
use Farid\App\Http\Middleware\ProfileMiddleware;

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

$routes->get('cabinet', '/cabinet', function (ServerRequestInterface $request) use ($params) {
    $auth = new BasicAuthMiddleware($params['users']);
    $profiler = new ProfileMiddleware();
    $cabinet = new CabinetAction();

    return $profiler($request, function (ServerRequestInterface $request) use ($cabinet, $auth) {
        return $auth($request, function (ServerRequestInterface $request) use ($cabinet) {
            return $cabinet($request);
        });
    });

});

$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(["id" => "\d+"]);

### ROUTING
$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $result->getHandler();
    $action = $resolver->resolve($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new HtmlResponse('Undefined page', 404);
}

### Post processing
$response = $response->withHeader("X-Developer", 'Fred');

### Sending
(new SapiEmitter())->emit($response);