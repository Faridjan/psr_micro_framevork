<?php

namespace Farid\Framework\Infrastructure\Framework\Console;

use Farid\App\Console\Command\CacheClearCommand;
use Farid\App\Service\FileManager;
use Psr\Container\ContainerInterface;

class CacheClearCommandFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CacheClearCommand(
            $container->get('config')['console']['cachePaths'],
            $container->get(FileManager::class)
        );
    }
}
