<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Dto\SlotRequest;
use App\Form\SlotType;
use App\Repository\Schedule\Slot\SlotManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Edit
{
    private $renderer;
    private $router;
    private $formFactory;
    private $slotManager;

    public function __construct(
        Twig $renderer,
        SlotManagerInterface $slotManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->slotManager = $slotManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $slot = $this->slotManager->find($request->attributes->get('id'));
        $slotRequest = SlotRequest::createFromSlot($slot);

        $form = $this->formFactory->create(SlotType::class, $slotRequest, [
            'method' => Request::METHOD_PUT,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slotRequest = $form->getData();
            $slotRequest->updateSlot($slot);
            $this->slotManager->save($slot);

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        return new Response($this->renderer->render('schedule/slot/edit.html.twig', [
            'slot' => $slot,
            'form' => $form->createView(),
        ]));
    }
}
