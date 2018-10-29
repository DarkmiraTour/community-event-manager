<?php

declare(strict_types=1);

namespace App\Controller\Organisation;

use App\Entity\Organisation;
use App\Form\OrganisationType;
use App\Repository\OrganisationRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    private $entityManager;
    private $router;

    public function __construct(
        \Twig_Environment $renderer,
        OrganisationRepository $repository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function handle(Request $request, int $id): Response
    {
        /** @var Organisation $organisation */
        $organisation = $this->repository->findOneById($id);

        if (null === $organisation) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->create(OrganisationType::class, $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('organisation_show', [
                'id' => $organisation->getId()
            ]));
        }

        return new Response($this->renderer->render('organisations/edit.html.twig', [
            'form' => $form->createView(), 'organisation' => $organisation
        ]));
    }
}
