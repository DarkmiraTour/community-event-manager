<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit\Edit;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class EditLevelPositionAction implements Action
{
    private $csrfTokenManager;
    private $sponsorshipLevelManager;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager
    ) {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $token = new CsrfToken('sponsorship-level-benefit', $request->request->get('_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            return new JsonResponse([false]);
        }

        $move = $request->request->get('move');
        $id = $request->request->get('id');

        $new_level = $this->sponsorshipLevelManager->switchPosition($move, $id);

        return new JsonResponse([
            'new_level_id' => $new_level->getId(),
        ]);
    }
}
