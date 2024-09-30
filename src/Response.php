<?php

namespace Src;
use Src\Interfaces\ResponseInterface;
class Response implements ResponseInterface {
    private $content;

    public function __construct($content) {
        $this->content = $content;
    }

    public function send(): string {
        return $this->content;
    }
}
