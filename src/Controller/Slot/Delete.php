<?php

declare(strict_types=1);

namespace App\Controller\Slot;

use App\Repository\Schedule\Slot\SlotManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Delete
{
    private $router;
    private $csrfTokenManager;
    private $manager;

    public function __construct(
        SlotManagerInterface $manager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->manager = $manager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request): RedirectResponse
    {
        $slot = $this->manager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$slot->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->manager->remove($slot);
        }

        return new RedirectResponse($this->router->generate('schedule_index'));
    }
}
