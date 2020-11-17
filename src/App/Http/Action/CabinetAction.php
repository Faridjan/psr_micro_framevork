<?php


namespace Farid\App\Http\Action;

use Farid\App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);
        return new HtmlResponse('<h2>I am logged in as ' . $username . '</h2>');
    }
}