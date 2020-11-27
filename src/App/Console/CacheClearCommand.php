<?php

namespace Farid\App\Console;


use Farid\App\Service\FileManager;
use Farid\Framework\Console\Command;
use Farid\Framework\Console\Input;
use Farid\Framework\Console\Output;

class CacheClearCommand extends Command
{
    private $paths;
    private $fileManager;

    public function __construct(array $paths, FileManager $fileManager)
    {
        $this->paths = $paths;
        $this->fileManager = $fileManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cache:clear')
            ->setDescription('Clearing cache');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeIn("<comment>Clearing cache</comment>");

        $alias = $input->getArguments(1);

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
            if ($this->fileManager->exist($path)) {
                $output->writeIn('Remove ' . $path);
                $this->fileManager->delete($path);
            } else {
                $output->writeIn('Skip ' . $path);
            }
        }
        $output->writeIn("<info>Done!</info>");
    }

}
