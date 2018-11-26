<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Dto\SlotRequest;
use App\Dto\SpaceRequest;
use App\Form\SlotType;
use App\Form\SpaceType;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Service\Schedule\CreateDailySchedule;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $repository;
    private $formFactory;
    private $scheduleService;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        ScheduleRepositoryInterface $repository,
        CreateDailySchedule $scheduleService
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->scheduleService = $scheduleService;
    }

    public function handle(Request $request): Response
    {
        $schedules = $this->repository->findAll();

        $form = $this->formFactory->create(SpaceType::class, new SpaceRequest());

        $formSlot = $this->formFactory->create(SlotType::class, new SlotRequest());

        return new Response($this->renderer->render('schedule/index.html.twig', [
            'schedules' => $schedules,
            'formSpace' => $form->createView(),
            'formSlot' => $formSlot->createView(),
            'timetable' => $this->scheduleService->mountTimetable($schedules),
        ]));
    }
}
