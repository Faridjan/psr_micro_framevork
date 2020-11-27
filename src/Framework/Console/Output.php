<?php


namespace Farid\Framework\Console;


class Output
{
    public function write(string $message): void
    {
        echo $this->process($message);
    }

    public function writeIn(string $message): void
    {
        echo $this->process($message . PHP_EOL);
    }

    public function process(string $message): string
    {
        return strtr($message, [
            "<comment>" => "\033[33m", "</comment>" => "\033[0m",
            "<info>" => "\033[32m", "</info>" => "\033[0m",
        ]);
    }
}