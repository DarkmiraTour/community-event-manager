<?php

declare(strict_types=1);

namespace App\Talk\Show;

use App\Action;
use App\Talk\TalkRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class ShowTalkAction implements Action
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
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $talk = $this->talkRepository->find($id);
        if (!$talk) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('talks/show.html.twig', [
            'talk' => $talk,
        ]));
    }
}
