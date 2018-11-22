<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevel;

use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
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
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('sponsorshipLevel/index.html.twig', [
            'levels' => $this->sponsorshipLevelManager->findAll(),
        ]));
    }
}
