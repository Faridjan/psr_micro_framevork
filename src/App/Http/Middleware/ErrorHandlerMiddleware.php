<?php


namespace Farid\App\Http\Middleware;


use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private $debug;

    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            if ($this->debug) {

//               TODO Switch to json response
//                return new JsonResponse([
//                    'error' => 'Server error',
//                    'code' => self::getStatusCode($e),
//                    'message' => $e->getMessage(),
//                    'trace' => $e->getTrace()
//                ], 500);

                dump([
                    'error' => 'Server error',
                    'code' => self::getStatusCode($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
            return new HtmlResponse('<h2>Server Error</h2>', 500);
        }
    }

    public function getStatusCode(\Throwable $e): int
    {
        $code = $e->getCode();
        if ($code >= 400 && $code < 600) {
            return $code;
        }
        return 500;
    }
}