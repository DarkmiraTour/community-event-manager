<?php

declare(strict_types=1);

namespace App\Controller\Login;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment as Twig;
use App\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;

final class Security
{
    private $environment;
    private $formFactory;

    public function __construct(Twig $environment, FormFactoryInterface $formFactory)
    {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
    }

    public function handle(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->formFactory->create(LoginType::class, ['last_username' => $lastUsername], [
            'method' => 'POST',
        ]);

        return new Response($this->environment->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'form' => $form->createView()
             ]));
    }
}
