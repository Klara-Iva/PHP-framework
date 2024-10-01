<?php

namespace Src;

use Src\Interfaces\ResponseInterface;

class JsonResponse implements ResponseInterface
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send(): string
    {
        header('Content-Type: application/json');
        return json_encode($this->content);
    }

}