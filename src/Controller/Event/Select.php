<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepository;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Repository\Schedule\ScheduleRepositoryManager;
use App\Repository\SponsorshipLevel\SponsorshipLevelRepositoryInterface;
use App\Service\Event\EventService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_USER')")
 */
final class Select
{
    private $renderer;
    private $eventRepository;
    private $eventService;
    private $scheduleRepository;
    private $scheduleManager;
    private $sponsorshipLevelRepository;

    public function __construct(
        Twig $renderer,
        EventRepository $eventRepository,
        EventService $eventService,
        ScheduleRepositoryInterface $scheduleRepository,
        ScheduleRepositoryManager $scheduleManager,
        SponsorshipLevelRepositoryInterface $sponsorshipLevelRepository
    ) {
        $this->renderer = $renderer;
        $this->eventRepository = $eventRepository;
        $this->eventService = $eventService;
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleManager = $scheduleManager;
        $this->sponsorshipLevelRepository = $sponsorshipLevelRepository;
    }

    public function handle(Request $request): Response
    {
        $eventId = Uuid::fromString($request->attributes->get('id'))->toString();

        if (!$event = $this->eventRepository->findById($eventId)) {
            throw new NotFoundHttpException(sprintf('The event could not be found this this id %s', $eventId));
        }

        if (!$this->eventService->isUserLoggedIn()) {
            throw new SessionUnavailableException('The user is not logged in');
        }

        $this->eventService->selectEvent($event);

        $schedules = $this->scheduleRepository->findScheduleAndSlots($event);

        return new Response($this->renderer->render('event/selected.html.twig', [
            'event' => $event,
            'schedules' => $schedules,
            'slotsTypes' => $this->scheduleManager->countSlotTypes($event, $schedules),
            'sponsorshipLevels' => $this->sponsorshipLevelRepository->findAllWithBenefits(),
        ]));
    }
}
