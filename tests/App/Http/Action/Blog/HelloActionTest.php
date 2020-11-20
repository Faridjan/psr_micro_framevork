<?php

namespace Tests\App\Http\Action;

use Farid\App\Http\Action\HelloAction;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;

class HelloActionTest extends TestCase
{
    public function testGuest()
    {
        $action = new HelloAction();

        $request = new ServerRequest();
        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('<h2>Hello, Guest!</h2>', $response->getBody()->getContents());
    }

    public function testJohn()
    {
        $action = new HelloAction();

        $request = (new ServerRequest())
            ->withQueryParams(['name' => 'John']);

        $response = $action($request);

        self::assertEquals('<h2>Hello, John!</h2>', $response->getBody()->getContents());
    }
}