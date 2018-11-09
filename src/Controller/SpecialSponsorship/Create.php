<?php

declare(strict_types=1);

namespace App\Controller\SpecialSponsorship;

use App\Form\SpecialSponsorshipType;
use App\Dto\SpecialSponsorshipRequest;
use App\Repository\SpecialSponsorship\SpecialSponsorshipManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

final class Create
{
    private $renderer;
    private $specialSponsorshipManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig_Environment $renderer,
        SpecialSponsorshipManagerInterface $specialSponsorshipManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->specialSponsorshipManager = $specialSponsorshipManager;
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
        $specialSponsorshipRequest = new SpecialSponsorshipRequest();

        $form = $this->formFactory->create(SpecialSponsorshipType::class, $specialSponsorshipRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialSponsorship = $this->specialSponsorshipManager->createFrom($specialSponsorshipRequest);
            $this->specialSponsorshipManager->save($specialSponsorship);

            return new RedirectResponse($this->router->generate('special_sponsorship_index'));
        }

        return new Response($this->renderer->render('specialSponsorship/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
