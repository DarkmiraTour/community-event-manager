<?php

declare(strict_types=1);

namespace App\Controller\SpaceType;

use App\Form\SpaceTypeType;
use App\Repository\Schedule\SpaceTypeRepositoryInterface;
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
    private $spaceTypeRepository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        SpaceTypeRepositoryInterface $spaceTypeRepository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->spaceTypeRepository = $spaceTypeRepository;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(SpaceTypeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $spaceType = $this->spaceTypeRepository->createFromRequest($form->getData());
            $this->spaceTypeRepository->save($spaceType);

            return new RedirectResponse($this->router->generate('schedule_space_type_index'));
        }

        return new Response($this->renderer->render('schedule/spaceType/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }

}
