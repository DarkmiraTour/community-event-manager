<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipBenefit;

use App\Dto\SponsorshipBenefitRequest;
use App\Form\SponsorshipBenefitType;
use App\Repository\SponsorshipBenefit\SponsorshipBenefitManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

final class Edit
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
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipBenefitManager = $sponsorshipBenefitManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Request $request, string $id): Response
    {
        $sponsorshipBenefit = $this->sponsorshipBenefitManager->find($id);

        if (null === $sponsorshipBenefit) {
            throw new NotFoundHttpException();
        }

        $sponsorshipBenefitRequest = SponsorshipBenefitRequest::createFromEntity($sponsorshipBenefit);

        $form = $this->formFactory->create(SponsorshipBenefitType::class, $sponsorshipBenefitRequest, [
            'method' => 'put',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
