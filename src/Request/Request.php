<?php

namespace Src\Request;

use Src\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $get;
    private $post;
    private $url;
    private $method;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
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

    public function getUrl()
    {
        return str_replace('/php-framework', '', $this->url);  
    }

    public function getMethod()
    {
        return $this->method;
    }

}