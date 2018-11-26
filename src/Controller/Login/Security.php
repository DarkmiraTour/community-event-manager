<?php

declare(strict_types=1);

namespace App\Controller\Login;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment as Twig;

final class Security
{
    private $environment;

    public function __construct(Twig $environment)
    {
        $this->environment = $environment;
    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response(
            $this->environment->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                 'error' => $error,
             ])
        );
    }

    public function signInSuccessful(): Response
    {
        return new Response(
            $this->environment->render('security/login_successful.html.twig')
        );
    }
}
