<?php

declare(strict_types=1);

namespace App\Sponsorship\SpecialBenefit\Delete;

use App\Action;
use App\Sponsorship\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class DeleteAction implements Action
{
    private $specialBenefitManager;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        SpecialBenefitManagerInterface $specialBenefitManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->specialBenefitManager = $specialBenefitManager;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $specialBenefit = $this->specialBenefitManager->find($request->attributes->get('id'));

        $token = new CsrfToken('delete'.$specialBenefit->getId(), $request->request->get('_token'));
        if ($this->csrfTokenManager->isTokenValid($token)) {
            $this->specialBenefitManager->remove($specialBenefit);
        }

        return new RedirectResponse($this->router->generate('special_benefit_index'));
    }
}
