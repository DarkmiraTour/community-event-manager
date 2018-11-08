<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Dto\OrganisationRequest;
use App\Form\OrganisationType;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Edit
{
    private $renderer;
    private $repository;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        OrganisationRepositoryInterface $repository,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request, string $id): Response
    {
        $organisation = $this->repository->find($id);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        $organisationRequest = OrganisationRequest::createFrom($organisation);
        $form = $this->formFactory->create(OrganisationType::class, $organisationRequest, [
            'method' => 'PUT',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisationRequest->updateOrganisation($organisation);
            $this->repository->save($organisation);

            return new RedirectResponse($this->router->generate('organisation_show', [
                'id' => $organisation->getId(),
            ]));
        }

        return new Response($this->renderer->render('organisations/edit.html.twig', [
            'form' => $form->createView(),
            'organisation' => $organisation,
        ]));
    }
}
