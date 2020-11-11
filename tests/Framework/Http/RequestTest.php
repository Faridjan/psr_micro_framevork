<?php

namespace Farid\Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Farid\Framework\Http\Request;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $_GET = [];
        $_POST = [];

        $request = new Request();
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsetBody());
    }
}