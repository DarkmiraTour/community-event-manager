<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $specialBenefitManager;

    public function __construct(Twig $renderer, SpecialBenefitManagerInterface $specialBenefitManager)
    {
        $this->renderer = $renderer;
        $this->specialBenefitManager = $specialBenefitManager;
    }

    public function handle(Request $request): Response
    {
        $specialBenefit = $this->specialBenefitManager->find($request->attributes->get('id'));

        return new Response($this->renderer->render('specialBenefit/show.html.twig', [
            'specialBenefit' => $specialBenefit,
        ]));
    }
}
