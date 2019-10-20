<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel\Index;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class IndexAction implements Action
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
    public function handle(Request $request): Response
    {
        return new Response($this->renderer->render('sponsorshipLevel/index.html.twig', [
            'levels' => $this->sponsorshipLevelManager->findAll(),
        ]));
    }
}
