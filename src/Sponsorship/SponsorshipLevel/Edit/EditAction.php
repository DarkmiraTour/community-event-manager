<?php

declare(strict_types=1);

namespace App\Sponsorship\SponsorshipLevel\Edit;

use App\Action;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelRequest;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelFormType;
use App\Sponsorship\SponsorshipLevel\SponsorshipLevelManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class EditAction implements Action
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $sponsorshipLevel = $this->sponsorshipLevelManager->find($request->attributes->get('id'));
        $sponsorshipLevelRequest = SponsorshipLevelRequest::createFromEntity($sponsorshipLevel);

        $form = $this->formFactory->create(SponsorshipLevelFormType::class, $sponsorshipLevelRequest, [
            'method' => Request::METHOD_PUT,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponsorshipLevelRequest = $form->getData();
            $sponsorshipLevelRequest->position = $sponsorshipLevel->getPosition();
            $sponsorshipLevelRequest->updateEntity($sponsorshipLevel);
            $this->sponsorshipLevelManager->save($sponsorshipLevel);

            return new RedirectResponse($this->router->generate('sponsorship_level_index'));
        }

        return new Response($this->renderer->render('sponsorshipLevel/edit.html.twig', [
            'level' => $sponsorshipLevel,
            'form' => $form->createView(),
        ]));
    }
}
