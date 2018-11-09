<?php

declare(strict_types=1);

namespace App\Controller\SpecialSponsorship;

use App\Repository\SpecialSponsorship\SpecialSponsorshipManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class Index
{
    private $renderer;
    private $specialSponsorshipManager;

    public function __construct(
        Twig_Environment $renderer,
        SpecialSponsorshipManagerInterface $specialSponsorshipManager
    )
    {
        $this->renderer = $renderer;
        $this->specialSponsorshipManager = $specialSponsorshipManager;
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('specialSponsorship/index.html.twig', [
            'specialSponsorships' => $this->specialSponsorshipManager->findAll(),
        ]));
    }
}
