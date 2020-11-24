<?php
//
//
//namespace Farid\Tests\Framework\Http\Pipeline;
//
//
//use Farid\Framework\Http\Pipeline\MiddlewareResolver;
//use Laminas\Diactoros\Response;
//use Laminas\Diactoros\ServerRequest;
//use PHPUnit\Framework\TestCase;
//
//class MiddlewareResolverTest extends TestCase
//{
//    public function testDirect($handler)
//    {
//        $resolver = new MiddlewareResolver(new DummyContainer());
//        $middleware = $resolver->resolve($handler, new Response());
//
//        $response = $middleware(
//            (new ServerRequest()->withAttribute('attribute', $value = 'value'));
//            new Response(),
//            new NotFoundMiddleware()
//        );
//
//        self::assertEquals([$value], $response->getHeader('X-Header'));
//    }
//
//    public function testNext($handler)
//    {
//        $resolver = new MiddlewareResolver();
//        $middleware = $resolver->resolve($handler, new Response());
//
//        $response = $middleware(
//            (new ServerRequest())->withAttribute('next', true),
//            new Response(),
//            new NotFoundMiddleware()
//        );
//
//        self::assertEquals(404, $response->getStatusCode());
//    }
//}