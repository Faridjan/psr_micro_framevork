<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Router\AuraRouterAdapter;
use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Aura\Router\RouterContainer;
use Farid\Framework\Http\Application;
use Laminas\Diactoros\Response;

use Farid\App\Http\Middleware\BasicAuthMiddleware;
use Farid\App\Http\Middleware\ProfileMiddleware;
use Farid\App\Http\Middleware\NotFoundHandler;
use Farid\App\Http\Middleware\CredentialsMiddleware;
use Farid\App\Http\Middleware\ErrorHandlerMiddleware;
use Farid\Framework\Middleware\RouteMiddleware;
use Farid\Framework\Middleware\DispatchMiddleware;

use Farid\App\Http\Action\HelloAction;
use Farid\App\Http\Action\AboutAction;
use Farid\App\Http\Action\Blog\IndexAction;
use Farid\App\Http\Action\Blog\ShowAction;
use Farid\App\Http\Action\CabinetAction;

require_once __DIR__ . '/../vendor/autoload.php';

### REQUEST
$request = ServerRequestFactory::fromGlobals();

### PARAMS
$params = [
    'debug' => true,
    'users' => ['admin' => 'password'],
];

### ROUTE COLLECTION / ACTIONS
$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', HelloAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('cabinet', '/cabinet', CabinetAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(["id" => "\d+"]);

### ROUTING
$router = new AuraRouterAdapter($aura);

### PIPELINE
$resolver = new MiddlewareResolver();
$app = new Application($resolver, new NotFoundHandler(), new Response());

//$app->pipe(new ErrorHandlerMiddleware($params['debug']));
$app->pipe(ProfileMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe(new RouteMiddleware($router)); // Определение маршрута
$app->pipe('cabinet', new BasicAuthMiddleware($params['users']));
$app->pipe(new DispatchMiddleware($resolver)); // Выполнение экшина

$response = $app->handle($request);

### Sending
(new SapiEmitter())->emit($response);


### CUSTOM
$contentType = $response->getHeader('content-type')[0];
if (preg_match('#html#i', $contentType)) {
    echo <<<END
    <style>
       * {
            box-sizing: border-box;
       }
       body {
            padding: 0;
            margin: 0;
           background: gray;
           color: #fff;
           display: flex;
           align-items: center;
           flex-direction: column;
           justify-content: center;
           height: 100vh;
       }
       h1,h2 {
       margin-top: 0;
       text-shadow: 1px 1px #555;
       }
    </style>
END;
}