<?php

namespace Farid\App\Http\Action\Blog;

use Laminas\Diactoros\Response\JsonResponse;

class IndexAction
{
    public function __invoke()
    {
        return new JsonResponse([
            ["id" => 1, "Title" => "Blog page #1"],
            ["id" => 2, "Title" => "Blog page #2"]
        ]);
    }
}