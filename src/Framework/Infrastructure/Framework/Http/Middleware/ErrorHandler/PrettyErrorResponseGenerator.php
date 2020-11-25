<?php

namespace Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler;


use Farid\Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response->withStatus(Utils::getStatusCode($e, new Response()));
        $response->getBody()->write('<h2>Server Error</h2>');
        return $response;
    }

}