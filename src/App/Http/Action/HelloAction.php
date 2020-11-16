<?php

namespace Farid\App\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;

class HelloAction
{
    public function __invoke()
    {
        return new JsonResponse('I am a simple site.');
    }
}