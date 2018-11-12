<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class Home
{
    public function __construct(Twig_Environment $renderer)
    {
        $this->renderer = $renderer;
    }
    public function handle(Request $request): Response
    {
        return new Response($this->renderer->render('home.html.twig'));
    }
}
