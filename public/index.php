<?php

use Farid\Framework\Container\Container;
use Farid\Framework\Http\Router\Router;
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
use Farid\Framework\Http\Middleware\RouteMiddleware;
use Farid\Framework\Http\Middleware\DispatchMiddleware;

use Farid\App\Http\Action\HelloAction;
use Farid\App\Http\Action\AboutAction;
use Farid\App\Http\Action\Blog\IndexAction;
use Farid\App\Http\Action\Blog\ShowAction;
use Farid\App\Http\Action\CabinetAction;

require_once __DIR__ . '/../vendor/autoload.php';


### CONFIGURATION
$container = new Container();
$container->set('config', [
    'debug' => true,
    'users' => ['admin' => 'pass']
]);
$container->set(Application::class, function (Container $container) {
    return new Application($container->get(MiddlewareResolver::class), new NotFoundHandler(), new Response());
});
$container->set(BasicAuthMiddleware::class, function (Container $container) {
    return new BasicAuthMiddleware($container->get('config')['users']);
});
$container->set(ErrorHandlerMiddleware::class, function (Container $container) {
    return new ErrorHandlerMiddleware($container->get('config')['debug']);
});
$container->set(MiddlewareResolver::class, function () {
    return new MiddlewareResolver();
});
$container->set(RouteMiddleware::class, function (Container $container) {
    return new RouteMiddleware($container->get(Router::class));
});
$container->set(DispatchMiddleware::class, function (Container $container) {
    return new DispatchMiddleware($container->get(MiddlewareResolver::class));
});
$container->set(Router::class, function () {
    ### ROUTE COLLECTION / ACTIONS
    $aura = new RouterContainer();
    $routes = $aura->getMap();

    $routes->get('home', '/', HelloAction::class);
    $routes->get('about', '/about', AboutAction::class);
    $routes->get('cabinet', '/cabinet', CabinetAction::class);
    $routes->get('blog', '/blog', IndexAction::class);
    $routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(["id" => "\d+"]);

    ### ROUTING
    return new AuraRouterAdapter($aura);
});


### REQUEST
$request = ServerRequestFactory::fromGlobals();

### PIPELINE
$app = $container->get(Application::class);

$app->pipe($container->get(ErrorHandlerMiddleware::class));
$app->pipe(ProfileMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe($container->get(RouteMiddleware::class)); // Определение маршрута
$app->pipe('cabinet', $container->get(BasicAuthMiddleware::class));
$app->pipe($container->get(DispatchMiddleware::class)); // Выполнение экшина

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