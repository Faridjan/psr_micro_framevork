<?php

namespace Farid\Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Farid\Framework\Http\Request;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_GET = [];
        $_POST = [];
    }

    public function testEmpty(): void
    {
        $_GET = [];
        $_POST = [];

        $request = new Request();
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsetBody());
    }

    public function testQueryParams(): void
    {
        $_GET = $data = [
            'name' => "John",
            'age' => '28'
        ];

        $request = new Request();

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsetBody());
    }

    public function testParsedBody()
    {
        $_POST = $data = ['title' => 'Test title'];

        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsetBody());
    }
}