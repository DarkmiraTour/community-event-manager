<?php

declare(strict_types=1);

namespace App\Talk\Index;

use App\Action;
use App\Talk\TalkRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class IndexAction implements Action
{
    private $renderer;
    private $talkRepository;

    public function __construct(Twig $renderer, TalkRepositoryInterface $talkRepository)
    {
        $this->renderer = $renderer;
        $this->talkRepository = $talkRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $talks = $this->talkRepository->findAll();

        return new Response($this->renderer->render('talks/index.html.twig', [
            'talks' => $talks,
        ]));
    }
}
