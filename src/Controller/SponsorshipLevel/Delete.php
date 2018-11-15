<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevel;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
final class Delete
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

    public function handle(Request $request, string $id): RedirectResponse
    {
        $sponsorshipLevel = $this->sponsorshipLevelManager->find($id);

        if (null === $sponsorshipLevel) {
            throw new NotFoundHttpException();
        }

        $token = new CsrfToken('delete'.$id, $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->sponsorshipLevelManager->remove($sponsorshipLevel);
        }

        return new RedirectResponse($this->router->generate('sponsorship_level_index'));
    }
}
