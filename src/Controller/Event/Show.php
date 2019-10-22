<?php

declare(strict_types=1);

namespace App\Controller\Event;

use App\Repository\Event\EventRepositoryInterface;
use App\Repository\SpeakerEventInterviewSent\SpeakerEventRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $eventRepository;
    private $speakerEventRepository;

    public function __construct(
        Twig $renderer,
        EventRepositoryInterface $repository,
        SpeakerEventRepositoryInterface $speakerEventRepository)
    {
        $this->renderer = $renderer;
        $this->eventRepository = $repository;
        $this->speakerEventRepository = $speakerEventRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $event = $this->eventRepository->findById($id);

        if (!$event) {
            throw new NotFoundHttpException();
        }

        $attendingSpeakers = $this->speakerEventRepository->findAllSpeakersByEvent($event);

        return new Response($this->renderer->render('event/show.html.twig', [
            'event' => $event,
            'attendingSpeakers' => $attendingSpeakers,
        ]));
    }
}
