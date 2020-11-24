<?php

namespace Farid\Framework\Http;

use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\Router;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Farid\Framework\Http\Router\RouteData;

use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application implements MiddlewareInterface, RequestHandlerInterface
{
    private MiddlewareResolver $resolver;
    private RequestHandlerInterface $default;
    private MiddlewarePipe $pipeline;
    private Router $router;
    private ResponseInterface $responsePrototype;


    /**
     * Application constructor.
     * @param MiddlewareResolver $resolver
     * @param Router $router
     * @param RequestHandlerInterface $default
     * @param ResponseInterface $responsePrototype
     */
    public function __construct(MiddlewareResolver $resolver, Router $router, RequestHandlerInterface $default, ResponseInterface $responsePrototype)
    {
        $this->resolver = $resolver;
        $this->router = $router;
        $this->pipeline = new MiddlewarePipe();
        $this->default = $default;
        $this->responsePrototype = $responsePrototype;
    }

    public function pipe($path, $middleware = null): void
    {
        if ($middleware === null) {
            $this->pipeline->pipe($this->resolver->resolve($path));
        } else {
            $this->pipeline->pipe(
                new PathMiddlewareDecorator(
                    $path,
                    $this->resolver->resolve($middleware)
                ));
        }
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->process($request, $this->default);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->pipeline->process($request, $handler);
    }

    public function get($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    public function post($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    public function any($name, $path, $handler, array $options = []): void
    {
        $this->route($name, $path, $handler, [], $options);
    }

    public function route($name, $path, $handler, array $methods, array $options = []): void
    {
        $this->router->addRouter(new RouteData($name, $path, $handler, $methods, $options));
    }
}