<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Farid\Framework\Http\Application;

/**
 * @var Psr\Container\ContainerInterface $container
 * @var Farid\Framework\Http\Application $app
 */

require_once __DIR__ . '/../vendor/autoload.php';


$container = require_once __DIR__ . '/../config/container.php';
$app = $container->get(Application::class);

require_once __DIR__ . '/../config/pipeline.php';
require_once __DIR__ . '/../config/routes.php';

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

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