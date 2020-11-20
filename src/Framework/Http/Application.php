<?php

namespace Farid\Framework\Http;

use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;

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
    private ResponseInterface $responsePrototype;


    /**
     * Application constructor.
     * @param MiddlewareResolver $resolver
     * @param RequestHandlerInterface $default
     * @param ResponseInterface $responsePrototype
     */
    public function __construct(MiddlewareResolver $resolver, RequestHandlerInterface $default, ResponseInterface $responsePrototype)
    {
        $this->resolver = $resolver;
        $this->pipeline = new MiddlewarePipe();
        $this->default = $default;
        $this->responsePrototype = $responsePrototype;
    }

    public function pipe($path, MiddlewareInterface $middleware = null): void
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
}