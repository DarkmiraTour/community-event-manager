<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepositoryInterface;
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
        EventRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        if (null === ($event = $this->repository->findById($id))) {
            throw new NotFoundHttpException(sprintf('The event could not be found this this id %s', $id));
        }

        return new Response($this->renderer->render('event/confirm_delete.html.twig', [
            'event' => $event,
        ]));
    }
}
