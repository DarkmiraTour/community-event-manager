<?php

namespace App\Controller\Speaker;

use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
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
    private $router;
    private $formFactory;
    private $speakerRepository;

    public function __construct(
        Twig_Environment $renderer,
        SpeakerRepository $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $speaker = $this->speakerRepository->find($request->attributes->get('id'));
        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->create(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->speakerRepository->save($speaker);

            return new RedirectResponse($this->router->generate('speaker_edit', ['id' => $speaker->getId()]));
        }

        return new Response($this->renderer->render('speaker/create.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]));
    }
}
