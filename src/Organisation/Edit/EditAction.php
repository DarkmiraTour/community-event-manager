<?php

declare(strict_types=1);

namespace App\Organisation\Edit;

use App\Action;
use App\Organisation\OrganisationFormType;
use App\Organisation\OrganisationRepositoryInterface;
use App\Organisation\OrganisationRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class EditAction implements Action
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

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $organisation = $this->repository->find($request->attributes->get('id'));

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        $organisationRequest = OrganisationRequest::createFrom($organisation);
        $form = $this->formFactory->create(OrganisationFormType::class, $organisationRequest, [
            'method' => Request::METHOD_PUT,
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
