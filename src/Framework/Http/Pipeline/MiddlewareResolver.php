<?php


namespace Farid\Framework\Http\Pipeline;


use Psr\Http\Message\RequestInterface;

class MiddlewareResolver
{
    public function resolve($handler): callable
    {
        if (\is_string($handler)) {
            return function (RequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();
                return $object($request, $next);
            };
        }

        return $handler;
    }
}