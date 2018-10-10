<?php

namespace Pipeline;

use Symfony\Component\HttpFoundation\RedirectResponse;
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

	/**
	 * @param \Symfony\Component\HttpFoundation\Request  $request
	 * @param \Symfony\Component\HttpFoundation\Response $response
	 *
	 * @return mixed|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|true
	 */
	public function execute(Request $request, Response $response)
	{
		foreach ($this->middlewares as $middleware) {
			$call = $this->call($middleware, $request, $response);

			if ($call instanceof RedirectResponse) {
				$response = $call;

				break;
			}

			if ($call instanceof $response) {
				$response = $call;

				continue;
			}
		}

		return $response;
	}

	/**
	 * @param                                            $middleware
	 * @param \Symfony\Component\HttpFoundation\Request  $request
	 * @param \Symfony\Component\HttpFoundation\Response $response
	 *
	 * @return mixed|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|true
	 */
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
