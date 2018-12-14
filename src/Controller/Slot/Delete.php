<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Repository\Schedule\SlotRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $router;
    private $csrfTokenManager;
    private $slotRepository;

    public function __construct(
        SlotRepositoryInterface $slotRepository,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->slotRepository = $slotRepository;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request, string $id): RedirectResponse
    {
        $slot = $this->slotRepository->find($id);

        if (!$slot) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete'.$id, $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->slotRepository->remove($slot);
        }

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
