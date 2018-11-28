<?php

declare(strict_types=1);

namespace App\Controller\Login;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class SignInSuccessful
{
    private $environment;

    public function __construct(Twig $environment)
    {
        $this->environment = $environment;
    }

    public function handle(): Response
    {
        return new Response(
            $this->environment->render('security/login_successful.html.twig')
        );
    }
}
