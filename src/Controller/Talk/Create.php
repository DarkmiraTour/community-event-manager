<?php

declare(strict_types=1);

namespace App\Controller\Talk;

use App\Form\TalkType;
use App\Repository\TalkRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Create
{
    private $renderer;
    private $formFactory;
    private $talkRepository;
    private $router;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        TalkRepositoryInterface $talkRepository,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->talkRepository = $talkRepository;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $form = $this->formFactory->create(TalkType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $talkRequest = $form->getData();
            $talk = $this->talkRepository->createFromRequest($talkRequest);
            $this->talkRepository->save($talk);

            return new RedirectResponse($this->router->generate('talk_index'));
        }

        return new Response($this->renderer->render('talks/create.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
