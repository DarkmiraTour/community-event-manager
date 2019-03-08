<?php

declare(strict_types=1);

namespace App\Controller\Talk;

use App\Repository\TalkRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmation
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

    public function handle(string $id): Response
    {
        $talk = $this->repository->find($id);
        if (null === $talk) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('talks/confirm_delete.html.twig', [
            'talk' => $talk,
        ]));
    }
}
