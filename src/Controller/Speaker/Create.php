<?php

namespace App\Controller\Speaker;

use App\Entity\Speaker;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
use App\Service\FileUploader;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

final class Create
{
    private $renderer;
    private $speakerRepository;
    private $formFactory;
    private $router;
    private $fileUploader;

    public function __construct(
        Twig_Environment $renderer,
        SpeakerRepository $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        FileUploader $fileUploader
    )
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->fileUploader = $fileUploader;
    }

    public function handle(Request $request): Response
    {
        $speaker = new Speaker();
        $form = $this->formFactory->create(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $this->fileUploader->upload($speaker->getPhoto());
            $speaker->setPhoto($filename);

            $this->speakerRepository->save($speaker);

            return new RedirectResponse($this->router->generate('speaker_index'));
        }

        return new Response($this->renderer->render('speaker/create.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]));
    }
}
