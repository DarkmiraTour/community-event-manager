<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipBenefit\Delete;

use App\Action;
use App\Sponsorship\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DeleteAction implements Action
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

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $sponsorshipBenefit = $this->sponsorshipBenefitManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$sponsorshipBenefit->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->sponsorshipBenefitManager->remove($sponsorshipBenefit);
        }

        return new RedirectResponse($this->router->generate('sponsorship_benefit_index'));
    }
}
