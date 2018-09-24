<?php

namespace Pipeline;

use Symfony\Component\HttpFoundation\Request;

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
