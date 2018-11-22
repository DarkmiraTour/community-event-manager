<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Home
{
    private $renderer;

    public function __construct(Twig $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(): Response
    {
        return new Response($this->renderer->render('home.html.twig'));
    }
}
