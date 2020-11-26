<?php

namespace Farid\App\Http\Action\Blog;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            ["id" => 1, "Title" => "Blog page #1"],
            ["id" => 2, "Title" => "Blog page #2"]
        ]);
    }
}
