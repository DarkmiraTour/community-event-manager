<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel\Delete;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DeleteAction implements Action
{
    private $sponsorshipLevelManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $sponsorshipLevel = $this->sponsorshipLevelManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$sponsorshipLevel->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->sponsorshipLevelManager->remove($sponsorshipLevel);
        }

        return new RedirectResponse($this->router->generate('sponsorship_level_index'));
    }
}
