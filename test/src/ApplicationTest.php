<?php

use PHPUnit\Framework\TestCase;
use Pipeline\Application;
use Symfony\Component\HttpFoundation\Request;

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
}
