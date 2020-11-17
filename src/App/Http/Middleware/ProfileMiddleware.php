<?php


namespace Farid\App\Http\Middleware;


use Psr\Http\Message\ServerRequestInterface;

class ProfileMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $stop = microtime(true);

        return $response->withHeader('X-Profiler-Time', $stop - $start);
    }


}