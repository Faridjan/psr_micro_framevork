<?php


namespace Farid\App\Http\Middleware;


use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ErrorHandlerMiddleware
{
    private $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (\Throwable $e) {
            if ($this->debug) {
//                return new JsonResponse([
//                    'error' => 'Server error',
//                    'code' => $e->getCode(),
//                    'message' => $e->getMessage(),
//                    'trace' => $e->getTrace()
//                ], 500);
                dump([
                    'error' => 'Server error',
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
            return new HtmlResponse('<h2>Server Error</h2>', 500);
        }
    }
}