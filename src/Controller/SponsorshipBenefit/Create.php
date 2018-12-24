<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Form\SponsorshipBenefitType;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $sponsorshipBenefitManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        SponsorshipBenefitManagerInterface $sponsorshipBenefitManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(SponsorshipBenefitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sponsorshipBenefitRequest = $form->getData();
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
