<?php


namespace Farid\Framework\Http\Middleware;

use Farid\Framework\Http\Router\Exception\RequestNotMatchedException;
use Farid\Framework\Http\Router\Result;
use Farid\Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware implements MiddlewareInterface
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $result = $this->router->match($request);
            foreach ($result->getAttributes() as $attribute => $value) {
                $request = $request->withAttribute($attribute, $value);
            }
            return $handler->handle($request->withAttribute(Result::class, $result));
        } catch (RequestNotMatchedException $e) {
            return $handler->handle($request);
        }
    }
}