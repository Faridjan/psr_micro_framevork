<?php

namespace Farid\App\Http\Action\Blog;

use Farid\App\ReadModel\Pagination;
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
        $pager = new Pagination(
            $this->posts->countAll(),
            $request->getQueryParams() ? $request->getQueryParams()['p'] : 1,
            self::PER_PAGE
        );

        $posts = $this->posts->getAll(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new JsonResponse([
            'posts' => $posts,
            'page' => $pager->getPage(),
            'count' => $pager->getPagesCount()
        ]);
    }
}
