<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Dto\SlotRequest;
use App\Form\SlotType;
use App\Repository\Schedule\SlotRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $router;
    private $renderer;
    private $formFactory;
    private $repository;
    private $flashBag;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SlotRepositoryInterface $repository,
        FlashBagInterface $flashBag
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->repository = $repository;
        $this->flashBag = $flashBag;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $slotRequest = new SlotRequest();

        $form = $this->formFactory->create(SlotType::class, $slotRequest);
        $form->handleRequest($request);

        if ($slotRequest->end <= $slotRequest->start) {
            $this->flashBag->add('error', 'The event cannot start after it ends');

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        $diff = $slotRequest->end->diff($slotRequest->start);
        if ($diff->i < 10 && $diff->h == 0) {
            $this->flashBag->add('error', 'The event should be longer than 10 minutes');

            return new RedirectResponse($this->router->generate('schedule_index'));
        }

        $slot = $this->repository->createFrom($slotRequest);

        try {
            $this->repository->save($slot);
        } catch (\LogicException $exception) {
            $this->flashBag->add('error', $exception->getMessage());
        }

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
