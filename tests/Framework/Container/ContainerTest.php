<?php


namespace Farid\Tests\Framework\Container;


use Farid\Framework\Container\Container;
use Farid\Framework\Container\ServiceNotFoundException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testPrimitives()
    {
        $container = new Container();

        $container->set($name = 'name', $value = 5);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = 'string');
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = ['array']);
        self::assertEquals($value, $container->get($name));

        $container->set($name = 'name', $value = new \StdClass());
        self::assertEquals($value, $container->get($name));
    }

    public function testCallback()
    {
        $container = new Container();

        $container->set($name = 'name', function () {
            return new \stdClass();
        });
        self::assertNotNull($value = $container->get($name));
        self::assertInstanceOf(\stdClass::class, $value);
    }

    public function testSingleton()
    {
        $container = new Container();
        $container->set($name = '44444', function () {
            return new \stdClass();
        });

        self::assertNotNull($value1 = $container->get($name));
        self::assertNotNull($value2 = $container->get($name));
        self::assertSame($value1, $value2);

//        dd($value1, $value2);
    }

    public function testContainerPass()
    {
        $container = new Container();

        $container->set('param', $value = 15);
        $container->set($name = 'name', function (Container $container) {
            $object = new \stdClass();
            $object->param = $container->get('param');
            return $object;
        });

        self::assertObjectHasAttribute('param', $object = $container->get($name));
        self::assertEquals($value, $object->param);
    }

    public function testNotFound()
    {
        $container = new Container();

        $this->expectException(ServiceNotFoundException::class);

        $container->get("email");
    }
}