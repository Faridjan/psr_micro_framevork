<?php

namespace Farid\Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $default): ResponseInterface
    {
        $delegate = new Next(clone $this->queue, $response, $default);
        return $delegate($request);
    }

    public function pipe($middleware): void
    {
        $this->queue->enqueue($middleware);
    }
}
