<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class renderPage implements renderPageInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $name, array $context): Response
    {
        return new Response(
            $this->twig->render($name, $context)
        );
    }
}
