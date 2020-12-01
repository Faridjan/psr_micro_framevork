<?php

namespace Farid\Infrastructure\Framework\Http\Router;

use Aura\Router\RouterContainer;
use Farid\Framework\Http\Router\AuraRouterAdapter;

class RouterFactory
{
    public function __invoke()
    {
        return new AuraRouterAdapter(new RouterContainer());
    }
}
