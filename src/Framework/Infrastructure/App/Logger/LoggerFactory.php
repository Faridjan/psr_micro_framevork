<?php

namespace Farid\Framework\Infrastructure\App\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $logger = new Logger('App');
        $logger->pushHandler(new StreamHandler(
            $container->get('config')['root_dir'] . '/var/log/application.log',
            $container->get('config')['debug'] ? Logger::DEBUG : Logger::WARNING
        ));
        return $logger;
    }
}
