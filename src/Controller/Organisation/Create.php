<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

final class Create
{
    private $renderer;
    private $formFactory;
    private $repository;
    private $router;

    public function __construct(
        \Twig_Environment $renderer,
        FormFactoryInterface $formFactory,
        OrganisationRepository $repository,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $organisation = new Organisation();
        $form = $this->formFactory->create(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($organisation);

            return new RedirectResponse($this->router->generate('organisation_list'));
        }

        return new Response(
            $this->renderer->render('organisations/create.html.twig', ['form' => $form->createView()])
        );
    }
}