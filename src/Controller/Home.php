<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\Event\EventRepository;
use App\Service\Event\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class Home
{
    private $renderer;
    private $eventRepository;
    private $router;

    /**
     * @var EventService
     */
    private $eventService;

    public function __construct(
        Twig $renderer,
        EventRepository $eventRepository,
        EventService $eventService,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->eventRepository = $eventRepository;
        $this->eventService = $eventService;
        $this->router = $router;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        if ($this->eventService->isEventSelected()) {
            return new RedirectResponse($this->router->generate('event_show', [
                'id' => $this->eventService->getSelectedEvent()->getId(),
            ]));
        }

        $events = $this->eventRepository->findAll();

        return new Response($this->renderer->render('home.html.twig', [
            'events' => $this->eventService->groupEventByTimeInterval($events),
        ]));
    }
}
