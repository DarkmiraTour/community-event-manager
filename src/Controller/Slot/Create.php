<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Dto\SlotRequest;
use App\Form\SlotType;
use App\Repository\Schedule\SlotRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $router;
    private $renderer;
    private $formFactory;
    private $repository;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SlotRepositoryInterface $repository
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
    }

    public function handle(Request $request): Response
    {
        $slotRequest = new SlotRequest();

        $form = $this->formFactory->create(SlotType::class, $slotRequest);
        $form->handleRequest($request);

        $slot = $this->repository->createFrom($slotRequest);

        $this->repository->save($slot);

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}