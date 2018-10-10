<?php

use PHPUnit\Framework\TestCase;
use Pipeline\Application;
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

	public function testRunSuccessfulResponse()
	{
		$request = Request::create('/');

		$app = new Application;
		$app->setRequest($request);
		$app->use(function (Request $request, Response $response) {
			return $response->setContent('Hello World');
		});

		// TODO: Figure out how to hide the content printed out when the test has run.
		$response = $app->run();

		$this->assertEquals(200, $response->getStatusCode());
		$this->assertEquals('Hello World', $response->getContent());
	}
}
