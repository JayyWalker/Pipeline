<?php

use PHPUnit\Framework\TestCase;

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
}
