<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Form\SlotType;
use App\Repository\Schedule\Slot\SlotManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Create
{
    private $router;
    private $formFactory;
    private $manager;
    private $renderer;

    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SlotManagerInterface $manager,
        Twig $renderer
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->manager = $manager;
        $this->renderer = $renderer;
    }

    public function handle(Request $request): JsonResponse
    {
        $form = $this->formFactory->create(SlotType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slotRequest = $form->getData();
            $slot = $this->manager->createFrom($slotRequest);
            $this->manager->save($slot);

            return new JsonResponse(null, Response::HTTP_CREATED);
        }

        return new JsonResponse([
            'form' => $this->renderer->render('schedule/modal/_body_add_slot.html.twig', [
                'form' => $form->createView(),
            ]),
        ], Response::HTTP_BAD_REQUEST);
    }
}
