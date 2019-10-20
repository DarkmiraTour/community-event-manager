<?php

declare(strict_types=1);

namespace App\Sponsorship\SpecialBenefit\Show;

use App\Action;
use App\Sponsorship\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class ShowAction implements Action
{
    private $renderer;
    private $specialBenefitManager;

    public function __construct(Twig $renderer, SpecialBenefitManagerInterface $specialBenefitManager)
    {
        $this->renderer = $renderer;
        $this->specialBenefitManager = $specialBenefitManager;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $specialBenefit = $this->specialBenefitManager->find($request->attributes->get('id'));

        return new Response($this->renderer->render('specialBenefit/show.html.twig', [
            'specialBenefit' => $specialBenefit,
        ]));
    }
}
