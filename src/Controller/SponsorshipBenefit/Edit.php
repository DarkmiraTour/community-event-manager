<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Dto\SponsorshipBenefitRequest;
use App\Form\SponsorshipBenefitType;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Edit
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
        $sponsorshipBenefit = $this->sponsorshipBenefitManager->find($request->attributes->get('id'));
        $sponsorshipBenefitRequest = SponsorshipBenefitRequest::createFromEntity($sponsorshipBenefit);

        $form = $this->formFactory->create(SponsorshipBenefitType::class, $sponsorshipBenefitRequest, [
            'method' => Request::METHOD_PUT,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponsorshipBenefitRequest = $form->getData();
            $sponsorshipBenefitRequest->updateEntity($sponsorshipBenefit);
            $this->sponsorshipBenefitManager->save($sponsorshipBenefit);

            return new RedirectResponse($this->router->generate('sponsorship_benefit_index'));
        }

        return new Response($this->renderer->render('sponsorshipBenefit/edit.html.twig', [
            'benefit' => $sponsorshipBenefit,
            'form' => $form->createView(),
        ]));
    }
}
