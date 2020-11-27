<?php


namespace Farid\App\Service;


class FileManager
{
    public function exist(string $path): bool
    {
        return file_exists($path);
    }

    public function delete($path): void
    {
        if (!$this->exist($path)) {
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
//
//    public function normalizePath(string $path): string
//    {
//        return __DIR__ . '/' . $path;
//    }
}