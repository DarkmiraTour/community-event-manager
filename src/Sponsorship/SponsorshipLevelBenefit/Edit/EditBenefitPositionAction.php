<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit\Edit;

use App\Action;
use App\Sponsorship\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class EditBenefitPositionAction implements Action
{
    private $csrfTokenManager;
    private $sponsorshipBenefitManager;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager
    ) {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
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

        $new_benefit = $this->sponsorshipBenefitManager->switchPosition($move, $id);

        return new JsonResponse([
            'new_benefit_id' => $new_benefit->getId(),
        ]);
    }
}
