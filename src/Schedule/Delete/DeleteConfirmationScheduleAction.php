<?php

declare(strict_types=1);

namespace App\Schedule\Delete;

use App\Schedule\ScheduleRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class DeleteConfirmationScheduleAction
{
    private $repository;
    private $renderer;

    public function __construct(
        ScheduleRepositoryInterface $repository,
        Twig $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(string $id): Response
    {
        $schedule = $this->repository->find($id);
        if (null === $schedule) {
            throw new NotFoundHttpException();
        }

        return new Response($this->renderer->render('schedule/configure/confirm_delete_day.html.twig', [
            'schedule' => $schedule,
        ]));
    }
}
