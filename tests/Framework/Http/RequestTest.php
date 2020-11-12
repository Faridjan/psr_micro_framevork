<?php

namespace Farid\Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Farid\Framework\Http\Request;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $request = new Request();
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testQueryParams(): void
    {
        $request = (new Request())->withQueryParams($data = [
            'name' => "John",
            'age' => '28'
        ]);

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testParsedBody()
    {
        $request = (new Request())->withParsedBody(
            $data = ["title" => "Test title"]
        );

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsedBody());
    }
}