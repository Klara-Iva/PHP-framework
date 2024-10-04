<?php

namespace Src\Interfaces;

interface RequestInterface
{
    public function get($key);
    public function post($key);
    public function getUrl();
    public function getMethod();
}