<?php

namespace Farid\App\Http\Action\Blog;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if ($id > 5) {
            return $next($request);
        }

        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}
