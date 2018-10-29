<?php

namespace App\Controller\Organisation;

use App\Entity\Organisation;
use App\Form\OrganisationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

final class Create
{
    private $renderer;
    private $formFactory;
    private $entityManager;
    private $router;

    public function __construct(
        \Twig_Environment $renderer,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $organisation = new Organisation();
        $form = $this->formFactory->create(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($organisation);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('organisation_list'));
        }

        return new Response(
            $this->renderer->render('organisations/create.html.twig', ['form' => $form->createView()])
        );
    }
}
