<?php


namespace Farid\App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class NotFoundHandler
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse('<H2>Undefined Page</H2>', 404);
    }
}