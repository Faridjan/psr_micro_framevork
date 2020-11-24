<?php


namespace Farid\App\Http\Action\Blog;


use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $id = $request->getAttribute('id');

        if ($id > 5) {
            return $next($request);
        }

        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}