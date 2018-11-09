<?php declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $speakerRepository;

    public function __construct(Twig $renderer, SpeakerRepositoryInterface $speakerRepository)
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
    }

    public function handle(): Response
    {
        $speakers = $this->speakerRepository->findAll();

        return new Response($this->renderer->render('speaker/index.html.twig', [
            'speakers' => $speakers,
        ]));
    }
}
