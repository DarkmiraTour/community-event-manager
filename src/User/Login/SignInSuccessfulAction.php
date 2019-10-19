<?php

declare(strict_types=1);

namespace App\User\Login;

use App\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class SignInSuccessfulAction implements Action
{
    private $environment;

    public function __construct(Twig $environment)
    {
        $this->environment = $environment;
    }

    public function handle(Request $request): Response
    {
        return new Response(
            $this->environment->render('security/login_successful.html.twig')
        );
    }
}
