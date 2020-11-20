<?php


namespace Farid\Framework\Http\Pipeline;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyMiddlewareDecorator implements MiddlewareInterface
{
    private $resolver;
    private $service;

    public function __construct(MiddlewareResolver $resolver, string $service)
    {
        $this->resolver = $resolver;
        $this->service = $service;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $middleware = $this->resolver->resolve(new $this->service);
        return $middleware->process($request, $handler);
    }
}