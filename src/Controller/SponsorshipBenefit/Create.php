<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Form\SponsorshipBenefitType;
use App\Dto\SponsorshipBenefitRequest;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

final class Create
{
    private $renderer;
    private $sponsorshipBenefitManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig_Environment $renderer,
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Request $request): Response
    {
        $sponsorshipBenefitRequest = new SponsorshipBenefitRequest();

        $form = $this->formFactory->create(SponsorshipBenefitType::class, $sponsorshipBenefitRequest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $position = $this->sponsorshipBenefitManager->getMaxPosition();
            $sponsorshipBenefitRequest->position = ++$position;

            $sponsorshipBenefit = $this->sponsorshipBenefitManager->createFrom($sponsorshipBenefitRequest);
            $this->sponsorshipBenefitManager->save($sponsorshipBenefit);

            return new RedirectResponse($this->router->generate('sponsorship_benefit_index'));
        }

        return new Response($this->renderer->render('sponsorshipBenefit/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
