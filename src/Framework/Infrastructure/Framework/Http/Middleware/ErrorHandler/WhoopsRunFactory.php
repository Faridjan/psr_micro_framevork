<?php

namespace Farid\Framework\Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Container\ContainerInterface;

class WhoopsRunFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $whoops = new \Whoops\Run();
        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        $whoops->register();
        return $whoops;
    }
}
