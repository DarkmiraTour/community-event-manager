<?php

declare(strict_types=1);

namespace App\User\Login;

use App\Action;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment as Twig;

final class SecurityAction implements Action
{
    private $environment;
    private $formFactory;
    private $authenticationUtils;

    public function __construct(Twig $environment, FormFactoryInterface $formFactory, AuthenticationUtils $authenticationUtils)
    {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function handle(Request $request): Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        $form = $this->formFactory->create(LoginFormType::class, ['last_username' => $lastUsername], [
            'method' => 'POST',
        ]);

        return new Response($this->environment->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error,
                'form' => $form->createView(),
             ]));
    }
}
