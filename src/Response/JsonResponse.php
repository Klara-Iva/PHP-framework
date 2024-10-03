<?php

namespace Src\Response;

use Src\Interfaces\ResponseInterface;

class JsonResponse implements ResponseInterface
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send(): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->content);
    }

}