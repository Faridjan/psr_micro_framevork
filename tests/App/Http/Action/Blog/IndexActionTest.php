<?php

namespace Farid\Tests\App\Http\Action\Blog;

use Farid\App\Http\Action\Blog\IndexAction;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class IndexActionTest extends TestCase
{
    public function testSuccess()
    {
        $action = new IndexAction();
        $response = $action->handle(new ServerRequest());

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                ['id' => 1, 'Title' => 'Blog page #1'],
                ['id' => 2, 'Title' => 'Blog page #2'],
            ]),
            $response->getBody()->getContents()
        );
    }
}