<?php

namespace Src\Request;

use Src\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $get;
    private $url;
    private $method;
    private $content;

    public function __construct()
    {
        $this->get = $_GET;
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->content = $this->checkContentType();
    }

    public function get($key = null)
    {
        if ($this->method === 'POST') {
            $data = $this->content;
        } else {
            $data = $this->get;
        }

        if ($key) {
            return isset($data[$key]) ? $data[$key] : null;
        }

        return $data;
    }

    private function checkContentType()
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            return json_decode(file_get_contents('php://input'), true) ?? [];
        } elseif (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
            return $_POST;
        }

        return [];
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