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
     * @var array
     */
    protected $middlewares = [];

    /**
     * @param $middleware
     *
     * @return $this
     */
    public function use ($middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function run ()
    {
        $response = new Response();

        foreach ($this->middlewares as $middleware) {
            $this->executeMiddleware($middleware, $response);
        }
    }

    public function executeMiddleware ($middleware, Response $response)
    {
        $callback = null;

        if (is_callable($middleware)) {

            // TODO: Change this into type hinted dependency injection.
            $callback = call_user_func_array($middleware, [
                $this->request,
                $response
            ]);
        }

        // TODO: Execute if $middleware is a class
        if (is_string($middleware) && class_exists($middleware)) {
            $callback = call_user_func_array(
            );
        }

        return $callback;
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
     * getMiddlewares
     *
     * @return array
     */
    public function getMiddlewares ()
    {
        return $this->middlewares;
    }
}
