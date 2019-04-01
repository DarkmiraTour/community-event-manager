<?php

declare(strict_types=1);

namespace App\Controller\SlotType;

use App\Form\SlotTypeType;
use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $slotTypeRepository;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        SlotTypeRepositoryInterface $slotTypeRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->slotTypeRepository = $slotTypeRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(SlotTypeType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slotTypeRequest = $form->getData();
            $slotType = $this->slotTypeRepository->createFrom($slotTypeRequest);
            $this->slotTypeRepository->save($slotType);

            return new RedirectResponse($this->router->generate('schedule_slot_type_index'));
        }

        return new Response($this->renderer->render('schedule/slotType/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
