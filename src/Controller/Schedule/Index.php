<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Repository\Schedule\ScheduleRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $repository;

    public function __construct(Twig $renderer, ScheduleRepositoryInterface $repository)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    public function handle(): Response
    {
        $schedule = $this->repository->findAll();

        $days = [];
        foreach ($schedule as $scheduleSingle) {
            $day = $scheduleSingle->getDay()->format('d-m');

            $days[$day] = $days[$day] ?? [];
            $days[$day][] = $scheduleSingle;
        }

        return new Response($this->renderer->render('schedule/index.html.twig', [
            'schedule' => $schedule,
            'days' => $days,
        ]));
    }
}