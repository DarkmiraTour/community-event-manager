<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevelBenefit;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Repository\SponsorshipLevelBenefit\SponsorshipLevelBenefitManagerInterface;
use App\Service\FormatSponsorshipLevelBenefit;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class View
{
    private $renderer;
    private $sponsorshipLevelBenefitManager;

    public function __construct(
        Twig_Environment $renderer,
        SponsorshipLevelBenefitManagerInterface $sponsorshipLevelBenefitManager
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipLevelBenefitManager = $sponsorshipLevelBenefitManager;
    }

    /**
     * @param FormatSponsorshipLevelBenefit    $formatSponsorshipLevelBenefit
     * @param SponsorshipLevelManagerInterface $sponsorshipLevelManager
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit, SponsorshipLevelManagerInterface $sponsorshipLevelManager): Response
    {
        return new Response($this->renderer->render('sponsorshipLevelBenefit/view.html.twig', [
            'levels' => $sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $formatSponsorshipLevelBenefit->format(),
        ]));
    }
}
