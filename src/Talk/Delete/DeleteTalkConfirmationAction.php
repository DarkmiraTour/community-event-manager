<?php

declare(strict_types=1);

namespace App\Talk\Delete;

use App\Action;
use App\Talk\TalkRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteTalkConfirmationAction implements Action
{
    private $repository;

    private $renderer;

    public function __construct(
        TalkRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(Request $request): Response
    {
        $talk = $this->repository->find($request->get('id'));
        if (null === $talk) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('talks/confirm_delete.html.twig', [
            'talk' => $talk,
        ]));
    }
}
