<?php

declare(strict_types=1);

namespace App\Controller\SlotType;

use App\Repository\Schedule\SlotRepository;
use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $slotTypeRepository;
    private $router;
    private $csrfTokenManager;
    private $flashBag;
    private $slotRepository;

    public function __construct(
        SlotTypeRepositoryInterface $slotTypeRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        FlashBagInterface $flashBag,
        SlotRepository $slotRepository
    ) {
        $this->slotTypeRepository = $slotTypeRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->flashBag = $flashBag;
        $this->slotRepository = $slotRepository;
    }

    public function handle(Request $request): RedirectResponse
    {
        $slotType = $this->slotTypeRepository->find($request->attributes->get('id'));

        $slots = $this->slotRepository->findBy([
            'type' => $slotType,
        ]);

        if ($slots) {
            $this->flashBag->add(
                'error',
                sprintf('"%s" is currently used in schedule and cannot be deleted', $slotType->getDescription())
            );

            return new RedirectResponse($this->router->generate('schedule_slot_type_index'));
        }

        $token = new CsrfToken('delete'.$slotType->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->slotTypeRepository->remove($slotType);
        }

        return new RedirectResponse($this->router->generate('schedule_slot_type_index'));
    }
}
