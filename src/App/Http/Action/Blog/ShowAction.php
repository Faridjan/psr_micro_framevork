<?php

namespace Farid\App\Http\Action\Blog;

use Farid\App\ReadModel\PostReadRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    private $posts;

    public function __construct(PostReadRepository $posts)
    {
        $this->posts = $posts;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if (!$post = $this->posts->find($request->getAttribute('id'))) {
            return $next($request);
        }

        return new JsonResponse($post);
    }
}
