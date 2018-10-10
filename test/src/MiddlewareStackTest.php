<?php

use PHPUnit\Framework\TestCase;

class MiddlewareStackTest extends TestCase
{
	public function testPush()
	{
		$class = new \Pipeline\MiddlewareStack;

		$class->push('Foo\\Bar');
		$class->push('Bar\\Foo');

		$this->assertEquals(
			['Foo\\Bar', 'Bar\\Foo'],
			$class->getMiddlewares()
		);
	}
}
