<?php declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $speakerRepository;

    public function __construct(Twig $renderer, SpeakerRepositoryInterface $speakerRepository)
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

        return new Response($this->renderer->render('speaker/show.html.twig', [
            'speaker' => $speaker
        ]));
    }
}
