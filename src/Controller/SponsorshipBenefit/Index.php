<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
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
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('sponsorshipBenefit/index.html.twig', [
            'benefits' => $this->sponsorshipBenefitManager->findAll(),
        ]));
    }
}
