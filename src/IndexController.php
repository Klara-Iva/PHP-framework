<?php

namespace Src;

class IndexController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
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
        return $this->twig->render('welcome.html');
    }

}