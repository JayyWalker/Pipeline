<?php

namespace Pipeline\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    public function __construct (Request $request, Response $response)
    {
    }

    public function handle ()
    {
    }
}