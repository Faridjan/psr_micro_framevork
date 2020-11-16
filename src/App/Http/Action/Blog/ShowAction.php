<?php


namespace Farid\App\Http\Action\Blog;


use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');

        if ($id > 5) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }

        return new JsonResponse(['id' => $id, 'Title' => 'Post #' . $id]);
    }
}