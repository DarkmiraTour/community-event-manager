<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        return new Response($this->renderer->render('specialBenefit/index.html.twig', [
            'specialBenefits' => $this->specialBenefitManager->findAll(),
        ]));
    }
}
