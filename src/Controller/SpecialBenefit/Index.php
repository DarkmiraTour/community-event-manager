<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $specialBenefitManager;

    public function __construct(
        Twig $renderer,
        SpecialBenefitManagerInterface $specialBenefitManager
    ) {
        $this->renderer = $renderer;
        $this->specialBenefitManager = $specialBenefitManager;
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
        return new Response($this->renderer->render('specialBenefit/index.html.twig', [
            'specialBenefits' => $this->specialBenefitManager->findAll(),
        ]));
    }
}
