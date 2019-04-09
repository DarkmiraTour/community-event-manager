<?php

declare(strict_types=1);

namespace App\Controller\Schedule;

use App\Dto\ScheduleRequest;
use App\Dto\SlotRequest;
use App\Dto\SpaceRequest;
use App\Exceptions\NoEventSelectedException;
use App\Form\ScheduleType;
use App\Form\SlotType;
use App\Form\SpaceType;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use App\Service\Schedule\CreateDailySchedule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $repository;
    private $formFactory;
    private $scheduleService;
    private $eventService;

    public function __construct(
        Twig $renderer,
        FormFactoryInterface $formFactory,
        ScheduleRepositoryInterface $repository,
        EventServiceInterface $eventService,
        CreateDailySchedule $scheduleService
    ) {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
        $this->repository = $repository;
        $this->scheduleService = $scheduleService;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        if (!$this->eventService->isUserLoggedIn() || !$this->eventService->isEventSelected()) {
            throw new NoEventSelectedException('No event has been selected');
        }

        $schedules = $this->repository->findBy(['event' => $this->eventService->getSelectedEvent()]);

        $form = $this->formFactory->create(SpaceType::class, new SpaceRequest());

        $formSlot = $this->formFactory->create(SlotType::class, new SlotRequest());

        $formSchedule = $this->formFactory->create(ScheduleType::class, new ScheduleRequest());

        return new Response($this->renderer->render('schedule/index.html.twig', [
            'schedules' => $schedules,
            'formSchedule' => $formSchedule->createView(),
            'formSpace' => $form->createView(),
            'formSlot' => $formSlot->createView(),
            'timetable' => $this->scheduleService->mountTimetable($schedules),
            'event' => $this->eventService->getSelectedEvent(),
        ]));
    }
}
