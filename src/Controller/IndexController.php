<?php

namespace Src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Src\Response\JsonResponse;

class IndexController
{
    private $twig;

    public function __construct(){}

    private function getTwig(): Environment
    {
        if ($this->twig === null) {
            $loader = new FilesystemLoader('templates');
            $this->twig = new Environment($loader);
        }
        
        return $this->twig;
    }

    public function indexAction()
    {
        return "WELCOME TO THE ORIGINALS!";
    }

    public function indexJsonAction()
    {
        return new JsonResponse(['message' => 'Welcome to JSON  default homepage!']);
    }

    public function indexTwigAction()
    {
        $twig = $this->getTwig();
        return $twig->render('welcome.html');
    }

}