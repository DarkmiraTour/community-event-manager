<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevelBenefit\Edit;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use App\Sponsorship\SponsorshipLevelBenefit\FormatSponsorshipLevelBenefit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class EditAction implements Action
{
    private $renderer;
    private $formatSponsorshipLevelBenefit;
    private $sponsorshipLevelManager;

    public function __construct(
        Twig $renderer,
        FormatSponsorshipLevelBenefit $formatSponsorshipLevelBenefit,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager
    ) {
        $this->renderer = $renderer;
        $this->formatSponsorshipLevelBenefit = $formatSponsorshipLevelBenefit;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        return new Response($this->renderer->render('sponsorshipLevelBenefit/edit.html.twig', [
            'levels' => $this->sponsorshipLevelManager->getOrderedList(),
            'levelBenefits' => $this->formatSponsorshipLevelBenefit->format(),
        ]));
    }
}
