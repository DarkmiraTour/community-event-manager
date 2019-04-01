<?php

declare(strict_types=1);

namespace App\Controller\SlotType;

use App\Repository\Schedule\SlotTypeRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $slotTypeRepository;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        SlotTypeRepositoryInterface $slotTypeRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->slotTypeRepository = $slotTypeRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request): RedirectResponse
    {
        $slotType = $this->slotTypeRepository->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$slotType->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->slotTypeRepository->remove($slotType);
        }

        return new RedirectResponse($this->router->generate('schedule_slot_type_index'));
    }
}
