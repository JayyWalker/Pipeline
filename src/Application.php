<?php

namespace Pipeline;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application 
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

	/**
	 * @var \Pipeline\MiddlewareStack
	 */
    protected $middlewares;

    public function __construct()
    {
    	$this->middlewares = new MiddlewareStack();
    }

	/**
     * @param $middleware
     *
     * @return $this
     */
    public function use ($middleware)
    {
        $this->middlewares->push($middleware);

        return $this;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return $this
     */
    public function setRequest (Request $request): Application
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest (): Request
    {
        return $this->request;
    }

	/**
	 * @return array
	 */
    public function getMiddlewares ()
    {
        return $this->middlewares->getMiddlewares();
    }

	public function run ()
	{
		$response = new Response;
		$response = $this->middlewares->execute($this->request, $response);

		$response->send();

		return $response;
    }
}
