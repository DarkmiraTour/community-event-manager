<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit\View;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Sponsorship\SponsorshipLevelBenefit\FormatSponsorshipLevelBenefit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class ViewAction implements Action
{
    private $renderer;
    private $formatSponsorshipLevelBenefit;
    private $sponsorshipLevelManager;

    public function __construct(
        FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        Twig $renderer
    ) {
        $this->renderer = $renderer;
        $this->formatSponsorshipLevelBenefit = $formatSponsorshipLevelBenefit;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        return new Response($this->renderer->render('sponsorshipLevelBenefit/view.html.twig', [
            'levels' => $this->sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $this->formatSponsorshipLevelBenefit->format(),
        ]));
    }
}
