<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

	/**
	 * @covers \Pipeline\MiddlewareStack::execute()
	 */
	public function testExecuteResponse()
	{
		$this->middlewareStack->push(
			function (Request $request, Response $response, $next) {
				return $response->setContent(json_encode([
					'data' => 'foo',
				]));
			}
		);
		$this->middlewareStack->push(
			function (Request $request, Response $response, $next) {
				return $response->headers->set('Content-Type', 'application/json');
			}
		);

		$request = Request::create('/');
		$baseResponse = new Response;

		$response = $this->middlewareStack->execute($request, $baseResponse);

		$this->assertEquals(
			'application/json', $response->headers->get('Content-Type')
		);
		$this->assertEquals(
			'{"data":"foo"}',
			$response->getContent()
		);
	}

	/**
	 * @covers \Pipeline\MiddlewareStack::execute()
	 */
	public function testExecuteRedirectResponse()
	{
		$this->middlewareStack->push(
			function (Request $request, Response $response, $next) {
				return new RedirectResponse('/foo');
			}
		);
		$this->middlewareStack->push(
			function (Request $request, Response $response, $next) {
				return $response->setContent('Hello World');
			}
		);

		$request = Request::create('/');
		$baseResponse = new Response;

		$response = $this->middlewareStack->execute($request, $baseResponse);

		$this->assertEquals(302, $response->getStatusCode());
		$this->assertEquals('/foo', $response->getTargetUrl());
	}
}
