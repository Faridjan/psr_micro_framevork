<?php


namespace Farid\App\Http\Middleware\ErrorHandler;


use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrettyErrorResponseGenerator implements ErrorResponseGenerator
{
    private $debug;

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function generate(\Throwable $e, ServerRequestInterface $request): ResponseInterface
    {
        if ($this->debug) {
//               TODO Switch to json response

//                return new JsonResponse([
//                    'error' => 'Server error',
//                    'code' => self::getStatusCode($e),
//                    'message' => $e->getMessage(),
//                    'trace' => $e->getTrace()
//                ], self::getStatusCode($e));

            dump([
                'error' => 'Server error',
                'code' => self::getStatusCode($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
        return new HtmlResponse('<h2>Server Error</h2>', self::getStatusCode($e));
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