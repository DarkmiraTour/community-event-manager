<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Form\SpecialBenefitType;
use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $specialBenefitManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        SpecialBenefitManagerInterface $specialBenefitManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->specialBenefitManager = $specialBenefitManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(SpecialBenefitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialBenefitRequest = $form->getData();
            $specialBenefit = $this->specialBenefitManager->createFrom($specialBenefitRequest);
            $this->specialBenefitManager->save($specialBenefit);

            return new RedirectResponse($this->router->generate('special_benefit_index'));
        }

        return new Response($this->renderer->render('specialBenefit/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
