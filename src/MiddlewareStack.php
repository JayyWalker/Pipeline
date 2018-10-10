<?php

namespace Pipeline;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareStack
{
	/**
	 * @var array
	 */
	protected $middlewares = [];

	/**
	 * @param string|callable $middleware
	 */
	public function push($middleware)
	{
		$this->middlewares[] = $middleware;
	}

	public function call($middleware, Request $request, Response $response)
	{
		$callback = call_user_func_array($middleware, [$request, $response, true]);

		return $callback;
	}

	/**
	 * @return array
	 */
	public function getMiddlewares(): array
	{
		return $this->middlewares;
	}
}
