<?php

namespace Farid\Framework\Http\Router\Exception;

use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchedException extends \LengthException
{
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Request not found.');
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
