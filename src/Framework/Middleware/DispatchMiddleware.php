<?php


namespace Farid\Framework\Middleware;


use Farid\Framework\Http\Pipeline\MiddlewareResolver;
use Farid\Framework\Http\Router\Result;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class DispatchMiddleware
{
    private $resolver;

    public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        /** @var Result $result * */
        if (!$result = $request->getAttribute(Result::class)) {
            return $next($request);
        };

        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware($request, $response, $next);
    }
}