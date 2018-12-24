<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Dto\OrganisationRequest;
use App\Form\OrganisationType;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $formFactory;
    private $repository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        OrganisationRepositoryInterface $repository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $organisationRequest = new OrganisationRequest();
        $form = $this->formFactory->create(OrganisationType::class, $organisationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisation = $this->repository->createFrom($organisationRequest);
            $this->repository->save($organisation);

            return new RedirectResponse($this->router->generate('organisation_list'));
        }

        return new Response($this->renderer->render('organisations/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
