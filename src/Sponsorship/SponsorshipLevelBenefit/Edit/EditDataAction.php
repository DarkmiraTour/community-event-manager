<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit\Edit;

use App\Action;
use App\Sponsorship\SponsorshipBenefit;
use App\Sponsorship\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use App\Sponsorship\SponsorshipLevel;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Sponsorship\SponsorshipLevelBenefit;
use App\Sponsorship\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Sponsorship\SponsorshipLevelBenefit\SponsorshipLevelBenefitRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class EditDataAction implements Action
{
    private $sponsorshipLevelBenefitManager;
    private $csrfTokenManager;
    private $sponsorshipLevelManager;
    private $sponsorshipBenefitManager;

    public function __construct(
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager,
        CsrfTokenManagerInterface $csrfTokenManager,
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager
    ) {
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
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

        $checked = $request->request->get('is_checked') !== 'false';
        $content = $request->request->get('text', null) ? $request->request->get('text') : null;

        $sponsorshipBenefit = $this->sponsorshipBenefitManager->find($request->request->get('benefit_id'));
        $sponsorshipLevel = $this->sponsorshipLevelManager->find($request->request->get('level_id'));

        $sponsorshipLevelBenefit = $this->sponsorshipLevelBenefitManager->getByBenefitAndLevel($sponsorshipBenefit, $sponsorshipLevel);
        if ($sponsorshipLevelBenefit) {
            return new JsonResponse($this->editSponsorshipLevelBenefit($checked, $sponsorshipLevelBenefit, $content));
        }
        if ($checked) {
            return new JsonResponse($this->addSponsorshipLevelBenefit($sponsorshipLevel, $sponsorshipBenefit, $content));
        }

        return new JsonResponse([false]);
    }

    private function editSponsorshipLevelBenefit(bool $checked, SponsorshipLevelBenefit $sponsorshipLevelBenefit, ?string $content): array
    {
        $sponsorshipLevelBenefitRequest = SponsorshipLevelBenefitRequest::createFromEntity($sponsorshipLevelBenefit);
        if ($checked) {
            $sponsorshipLevelBenefitRequest->content = $content;
            $sponsorshipLevelBenefitRequest->updateEntity($sponsorshipLevelBenefit);
            $this->sponsorshipLevelBenefitManager->save($sponsorshipLevelBenefit);

            return [true];
        }
        $this->sponsorshipLevelBenefitManager->remove($sponsorshipLevelBenefit);

        return [true];
    }

    private function addSponsorshipLevelBenefit(SponsorshipLevel $sponsorshipLevel, SponsorshipBenefit $sponsorshipBenefit, ?string $content): array
    {
        $sponsorshipLevelBenefitRequest = new SponsorshipLevelBenefitRequest(
            $sponsorshipLevel,
            $sponsorshipBenefit,
            $content
        );
        $sponsorshipLevelBenefit = $this->sponsorshipLevelBenefitManager->createFrom($sponsorshipLevelBenefitRequest);
        $this->sponsorshipLevelBenefitManager->save($sponsorshipLevelBenefit);

        return [true];
    }
}
