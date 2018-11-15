<?php

declare(strict_types=1);

namespace App\Controller\SpecialBenefit;

use App\Dto\SpecialBenefitRequest;
use App\Entity\SpecialBenefit;
use App\Form\SpecialBenefitType;
use App\Repository\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment As Twig;

final class Edit
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
    )
    {
        $this->renderer = $renderer;
        $this->specialBenefitManager = $specialBenefitManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param SpecialBenefit $specialBenefit
     * @ParamConverter("specialBenefit", class="App:SpecialBenefit")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(Request $request, SpecialBenefit $specialBenefit): Response
    {
        $specialBenefitRequest = SpecialBenefitRequest::createFromEntity($specialBenefit);

        $form = $this->formFactory->create(SpecialBenefitType::class, $specialBenefitRequest, [
            'method' => 'put',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialBenefitRequest->updateEntity($specialBenefit);
            $this->specialBenefitManager->save($specialBenefit);

            return new RedirectResponse($this->router->generate('special_benefit_index'));
        }

        return new Response($this->renderer->render('specialBenefit/edit.html.twig', [
            'specialBenefit' => $specialBenefit,
            'form' => $form->createView(),
        ]));
    }
}
