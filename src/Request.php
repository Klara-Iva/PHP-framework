<?php

namespace Src;

use Src\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $get;
    private $post;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function get($key = null)
    {
        if ($key) {
            return isset($this->get[$key]) ? $this->get[$key] : null;
        }
        return $this->get;
    }

    public function post($key = null)
    {
        if ($key) {
            return isset($this->post[$key]) ? $this->post[$key] : null;
        }

        return $this->post;
    }

}