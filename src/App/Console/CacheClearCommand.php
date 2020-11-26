<?php


namespace Farid\App\Console;


use Farid\Framework\Console\Input;

class CacheClearCommand
{
    private $paths = [
        'log' => 'var/log',
        'db' => 'var/db',
        'twig' => 'var/twig'
    ];

    public function execute(Input $input): void
    {
        echo 'Clearing cache' . PHP_EOL;

        $alias = $input->getArguments(0);

        if (empty($alias)) {
            $alias = $input->choose('Choose path', array_merge(array_keys($this->paths), ['all']));
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
            }
            $paths = [$alias => $this->paths[$alias]];
        }
        foreach ($paths as $path) {
            if (file_exists($path)) {
                echo 'Remove ' . $path . PHP_EOL;
                $this->delete($path);
            } else {
                echo 'Skip ' . $path . PHP_EOL;
            }
        }
    }

    private static function delete($path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException('Undefined path ' . $path);
        }

        if (is_dir($path)) {

            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                self::delete($path . DIRECTORY_SEPARATOR . $item);
            }
            if (!rmdir($path)) {
                throw new \RuntimeException('Unable to delete directory ' . $path);
            }
        } else {
            if (!unlink($path)) {
                throw new \RuntimeException('Unable to delete file ' . $path);
            }
        }
    }
}
