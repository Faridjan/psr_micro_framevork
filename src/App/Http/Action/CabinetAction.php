<?php


namespace Farid\App\Http\Action;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getAttribute('username');
        return new HtmlResponse('I am logged in as ' . $username);
    }
}