<?php


namespace Farid\Tests\Framework\Http\Pipeline;


use Farid\Framework\Container\ServiceNotFoundException;

class DummyContainer
{
    public function get($id)
    {
        if (!class_exists($id)) {
            throw new ServiceNotFoundException($id);
        }
        return new $id();
    }

    public function has($id): bool
    {
        return class_exists($id);
    }
}