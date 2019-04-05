<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepository;
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
    private $repository;
    private $eventService;

    public function __construct(Twig $renderer, EventRepository $repository, EventService $eventService)
    {
        $this->renderer = $renderer;
        $this->repository = $repository;
        $this->eventService = $eventService;
    }

    public function handle(Request $request): Response
    {
        $eventId = Uuid::fromString($request->attributes->get('id'))->toString();

        if (!$event = $this->repository->findById($eventId)) {
            throw new NotFoundHttpException(sprintf('The event could not be found this this id %s', $eventId));
        }

        if (!$this->eventService->isUserLoggedIn()) {
            throw new SessionUnavailableException('The user is not logged in');
        }

        $this->eventService->selectEvent($event);

        return new Response($this->renderer->render('event/selected.html.twig', ['event' => $event]));
    }
}
