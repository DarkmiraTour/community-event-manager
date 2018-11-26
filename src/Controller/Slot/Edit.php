<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Dto\SlotRequest;
use App\Form\SlotType;
use App\Repository\Schedule\SlotRepositoryInterface;
use Ramsey\Uuid\Uuid;
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
    private $router;
    private $formFactory;
    private $slotRepository;

    public function __construct(
        Twig $renderer,
        SlotRepositoryInterface $slotRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->slotRepository = $slotRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $slot = $this->slotRepository->find($id);
        if (!$slot) {
            throw new NotFoundHttpException();
        }

        $slotRequest = SlotRequest::createFromEntity($slot);
        $form = $this->formFactory->create(SlotType::class, $slotRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slot = $slotRequest->updateSlot($slot);
            $this->slotRepository->save($slot);

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        return new Response($this->renderer->render('schedule/slot/edit.html.twig', [
            'slot' => $slot,
            'form' => $form->createView(),
        ]));
    }
}
