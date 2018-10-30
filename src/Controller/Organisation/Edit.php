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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

final class Edit
{
    private $renderer;
    private $repository;
    private $formFactory;
    private $router;

    public function __construct(
        \Twig_Environment $renderer,
        OrganisationRepository $repository,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request, int $id): Response
    {
        /** @var Organisation $organisation */
        $organisation = $this->repository->find($id);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->create(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($organisation);

            return new RedirectResponse($this->router->generate('organisation_show', [
                'id' => $organisation->getId()
            ]));
        }

        return new Response($this->renderer->render('organisations/edit.html.twig', [
            'form' => $form->createView(), 'organisation' => $organisation
        ]));
    }
}
