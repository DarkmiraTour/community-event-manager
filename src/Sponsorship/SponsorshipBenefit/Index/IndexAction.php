<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipBenefit\Index;

use App\Action;
use App\Sponsorship\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class IndexAction implements Action
{
    private $renderer;
    private $sponsorshipBenefitManager;

    public function __construct(
        Twig $renderer,
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        return new Response($this->renderer->render('sponsorshipBenefit/index.html.twig', [
            'benefits' => $this->sponsorshipBenefitManager->findAll(),
        ]));
    }
}
