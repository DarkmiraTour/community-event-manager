<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevel;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $sponsorshipLevelManager;

    public function __construct(
        Twig $renderer,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('sponsorshipLevel/index.html.twig', [
            'levels' => $this->sponsorshipLevelManager->findAll(),
        ]));
    }
}
