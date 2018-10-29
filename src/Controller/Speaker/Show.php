<?php

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig_Environment;

final class Show
{
    private $renderer;
    private $speakerRepository;

    public function __construct(Twig_Environment $renderer, SpeakerRepository $speakerRepository)
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
    }

    public function handle(Request $request): Response
    {
        $speaker = $this->speakerRepository->find($request->attributes->get('id'));
        if (!$speaker) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('speaker/show.html.twig', ['speaker' => $speaker]));
    }
}
