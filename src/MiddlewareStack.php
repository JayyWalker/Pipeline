<?php

namespace Pipeline;

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

	/**
	 * @return array
	 */
	public function getMiddlewares(): array
	{
		return $this->middlewares;
	}
}
