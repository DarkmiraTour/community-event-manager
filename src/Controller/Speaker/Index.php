<?php

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

final class Index
{
    private $renderer;
    private $speakerRepository;

    public function __construct(Twig_Environment $renderer, SpeakerRepository $speakerRepository)
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
    }

    public function handle(): Response
    {
        $speakers = $this->speakerRepository->findAll();

        return new Response($this->renderer->render('speaker/index.html.twig', ['speakers' => $speakers]));
    }
}
