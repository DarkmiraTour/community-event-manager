<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class Delete
{
    private $sponsorshipBenefitManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function handle(Request $request): RedirectResponse
    {
        $sponsorshipBenefit = $this->sponsorshipBenefitManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$sponsorshipBenefit->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->sponsorshipBenefitManager->remove($sponsorshipBenefit);
        }

        return new RedirectResponse($this->router->generate('sponsorship_benefit_index'));
    }
}
