<?php


namespace Farid\Framework\Infrastructure\Framework\Console;


use Farid\App\Console\CacheClearCommand;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CacheClearCommand($container->get('config')['console']['cachePaths']);
    }
}