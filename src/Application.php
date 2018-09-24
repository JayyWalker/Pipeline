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
}
