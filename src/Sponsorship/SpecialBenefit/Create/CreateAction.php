<?php

declare(strict_types=1);

namespace App\Sponsorship\SpecialBenefit\Create;

use App\Action;
use App\Sponsorship\SpecialBenefit\SpecialBenefitFormType;
use App\Sponsorship\SpecialBenefit\SpecialBenefitManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class CreateAction implements Action
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(SpecialBenefitFormType::class);
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
