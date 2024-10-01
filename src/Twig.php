<?php

namespace Src;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Twig
{
    private $twig;

    public function __construct(string $templatesPath)
    {
        $loader = new FilesystemLoader($templatesPath);
        $this->twig = new Environment($loader);
    }

    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
    
}