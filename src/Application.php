<?php

namespace Pipeline;

use Symfony\Component\HttpFoundation\Request;

class Application 
{
    /**
     * @var Symfony\Component\HttpFoundation\Request
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
     * setRequest
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function setRequest (Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * getRequest
     * 
     * @return Symfony\Component\HttpFoundation\Request
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
