<?php

declare(strict_types=1);

namespace App\Controller\Login;

use App\Form\UserType;
use Twig\Environment as Twig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\User\UserManagerInterface;
use App\Dto\UserRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

final class Registration
{
    private $environment;
    private $formFactory;
    private $userManager;
    private $router;

    public function __construct(Twig $environment, FormFactoryInterface $formFactory, UserManagerInterface $userManager, RouterInterface $router)
    {
        $this->environment = $environment;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $userRequest = new UserRequest();
        $form = $this->formFactory->create(UserType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $this->userManager->create(
                $userRequest->getEmail(),
                $userRequest->getUsername(),
                $userRequest->getPlainPassword()
            );
            $this->userManager->save($newUser);

            return new RedirectResponse($this->router->generate('index'));
        }

        return new Response($this->environment->render('users/register.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
