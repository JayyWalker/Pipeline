<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Pipeline\Application;
use Pipeline\Middleware\TestMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicationTest extends TestCase
{
    public function testSetRequest ()
    {
        $request = Request::create('/foo');

        $app = new Application;
        $app->setRequest($request);

        $this->assertSame(
            $request,
            $app->getRequest()
        );
    }

    public function testUse ()
    {
        $app = new Application;
        $app->use('Foo\\Bar');

        $this->assertContains(
            'Foo\\Bar',
            $app->getMiddlewares()
        );
    }

    /**
     * @covers \Pipeline\Application::executeMiddleware()
     */
    public function testMiddlewareIsCallable ()
    {
        $app = new Application;
        $app->setRequest(Request::create('/'));
        $app->use(function (Request $request, Response $response) {
            return $response->setContent('Hello World');
        });

        $middleware = $app->getMiddlewares()[0];

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $app->executeMiddleware($middleware, new Response);

        $this->assertEquals(
            'Hello World',
            $response->getContent()
        );
    }

    /**
     * @covers \Pipeline\Application::executeMiddleware()
     */
    public function testMiddlewareIsClass ()
    {
        $app = new Application;
        $app->setRequest(Request::create('/'));
        $app->use(TestMiddleware::class);

        $middleware = $app->getMiddlewares()[0];

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $app->executeMiddleware($middleware, new Response);

        $this->assertEquals(
            'Hello World',
            $response->getContent()
        );
    }
}
