<?php

declare(strict_types=1);

namespace App\Controller\SpecialSponsorship;

use App\Repository\SpecialSponsorship\SpecialSponsorshipManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $specialSponsorshipManager;

    public function __construct(Twig $renderer, SpecialSponsorshipManagerInterface $specialSponsorshipManager)
    {
        $this->renderer = $renderer;
        $this->specialSponsorshipManager = $specialSponsorshipManager;
    }

    public function handle(string $id): Response
    {
        $specialSponsorship = $this->specialSponsorshipManager->find($id);

        if (null === $specialSponsorship) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('specialSponsorship/show.html.twig', [
            'specialSponsorship' => $specialSponsorship,
        ]));
    }
}
