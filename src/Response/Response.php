<?php

namespace Src\Response;

use Src\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send(): void
    {
        if ($this->content instanceof JsonResponse) {
            $this->content->send();  
        } else {
            echo $this->content;  
        }
        
    }

}