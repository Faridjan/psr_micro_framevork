<?php

namespace Farid\Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;


interface Router
{
    public function match(ServerRequestInterface $request): Result;

    public function generate($name, array $params): string;

    public function addRouter(RouteData $data): void;
}