<?php

namespace Farid\App\Http\Action\Blog;

use Farid\App\ReadModel\PostReadRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    private const PER_PAGE = 5;

    private $posts;

    public function __construct(PostReadRepository $posts)
    {
        $this->posts = $posts;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getQueryParams() ? $request->getQueryParams()['p'] : 1;

        $offset = ($page - 1) * self::PER_PAGE;
        $limit = self::PER_PAGE;
        $total = $this->posts->countAll();

        $count = ceil($total / $limit);

        $posts = $this->posts->getAll($offset, $limit);

        return new JsonResponse([
            'posts' => $posts,
            'page' => $page,
            'count' => $count
        ]);
    }
}
