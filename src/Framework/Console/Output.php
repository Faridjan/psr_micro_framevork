<?php


namespace Farid\Framework\Console;


class Output
{
    public function write(string $message): void
    {
        echo $message;
    }

    public function writeIn(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function info(string $message): void
    {
        $this->writeIn("\033[32m" . $message . "\033[0m");
    }

    public function comment(string $message): void
    {
        $this->writeIn("\033[33m" . $message . "\033[0m");
    }
}