<?php

declare(strict_types=1);

namespace App\Speaker\Index;

use App\Action;
use App\Speaker\SpeakerRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class IndexAction implements Action
{
    private $renderer;
    private $speakerRepository;

    public function __construct(Twig $renderer, SpeakerRepositoryInterface $speakerRepository)
    {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $speakers = $this->speakerRepository->findAll();

        return new Response($this->renderer->render('speaker/index.html.twig', [
            'speakers' => $speakers,
        ]));
    }
}
