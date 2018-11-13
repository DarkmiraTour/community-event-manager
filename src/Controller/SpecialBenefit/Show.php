<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Entity\SpecialBenefit;
use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

    /**
     * @param SpecialBenefit $specialBenefit
     * @ParamConverter("specialBenefit", class="App:SpecialBenefit")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(SpecialBenefit $specialBenefit): Response
    {
        return new Response($this->renderer->render('specialBenefit/show.html.twig', [
            'specialBenefit' => $specialBenefit,
        ]));
    }
}
