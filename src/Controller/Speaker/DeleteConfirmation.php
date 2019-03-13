<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerRepositoryInterface;
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
        SpeakerRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $speaker = $this->repository->find($id);
        if (null === $speaker) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('speaker/confirm_delete.html.twig', [
            'speaker' => $speaker,
        ]));
    }
}
