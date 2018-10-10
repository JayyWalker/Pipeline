<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareStackTest extends TestCase
{
	/**
	 * @var \Pipeline\MiddlewareStack
	 */
	protected $middlewareStack;

	protected function setUp()
	{
		$this->middlewareStack = new \Pipeline\MiddlewareStack;
	}

	public function testPush()
	{
		$this->middlewareStack->push('Foo\\Bar');
		$this->middlewareStack->push('Bar\\Foo');

		$this->assertEquals(
			['Foo\\Bar', 'Bar\\Foo'],
			$this->middlewareStack->getMiddlewares()
		);
	}

	/**
	 * @covers \Pipeline\MiddlewareStack::call()
	 */
	public function testCallReturnsResponse()
	{
		$middleware = function (Request $request, Response $response) {
			return $response->setContent('Hello World');
		};

		$request = Request::create('/');
		$response = new Response;
		$this->assertEquals(
			$response->setContent('Hello World'),
			$this->middlewareStack->call($middleware, $request, new Response)
		);
	}

	/**
	 * @covers \Pipeline\MiddlewareStack::call()
	 */
	public function testCallReturnsNext()
	{
		$middleware = function (Request $request, Response $response, $next) {
			return $next;
		};

		$request = Request::create('/');
		$this->assertTrue(
			$this->middlewareStack->call($middleware, $request, new Response)
		);
	}
}
