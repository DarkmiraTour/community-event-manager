<?php

declare(strict_types=1);

namespace App\Controller\SponsorshipLevel;

use App\Form\SponsorshipLevelType;
use App\Dto\SponsorshipLevelRequest;
use App\Repository\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $sponsorshipLevelManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        SponsorshipLevelManagerInterface $sponsorshipLevelManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->sponsorshipLevelManager = $sponsorshipLevelManager;
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
        $sponsorshipLevelRequest = new SponsorshipLevelRequest();

        $form = $this->formFactory->create(SponsorshipLevelType::class, $sponsorshipLevelRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $position = $this->sponsorshipLevelManager->getMaxPosition();
            $sponsorshipLevelRequest->position = ++$position;

            $sponsorshipLevel = $this->sponsorshipLevelManager->createFrom($sponsorshipLevelRequest);
            $this->sponsorshipLevelManager->save($sponsorshipLevel);

            return new RedirectResponse($this->router->generate('sponsorship_level_index'));
        }

        return new Response($this->renderer->render('sponsorshipLevel/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
