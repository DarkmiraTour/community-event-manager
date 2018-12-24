<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevelBenefit;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Service\FormatSponsorshipLevelBenefit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class View
{
    private $renderer;
    private $sponsorshipLevelBenefitManager;

    public function __construct(
        Twig $renderer,
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit, SponsorshipLevelManagerInterface $sponsorshipLevelManager): Response
    {
        return new Response($this->renderer->render('sponsorshipLevelBenefit/view.html.twig', [
            'levels' => $sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $formatSponsorshipLevelBenefit->format(),
        ]));
    }
}
