<?php

declare(strict_types=1);

namespace App\Controller\Talk;

use App\Repository\TalkRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
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
    public function handle(): Response
    {
        $talks = $this->talkRepository->findAll();

        return new Response($this->renderer->render('talks/index.html.twig', [
            'talks' => $talks,
        ]));
    }
}
