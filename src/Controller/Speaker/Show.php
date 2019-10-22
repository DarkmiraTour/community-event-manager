<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerEventInterviewSent\SpeakerEventInterviewSentRepository;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment as Twig;

final class Show
{
    private $renderer;
    private $speakerRepository;
    private $eventService;
    private $speakerEventInterviewSentRepository;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        EventServiceInterface $eventService,
        SpeakerEventInterviewSentRepository $speakerEventInterviewSentRepository
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->eventService = $eventService;
        $this->speakerEventInterviewSentRepository = $speakerEventInterviewSentRepository;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $speaker = $this->speakerRepository->find($id);

        if (!$speaker) {
            throw new NotFoundHttpException();
        }
        $attendingEvents = $this->speakerEventInterviewSentRepository->findAllEventsBySpeaker($speaker);

        if ($this->eventService->isEventSelected()) {
            $event = $this->eventService->getSelectedEvent();
            $sendInterview = $this->speakerEventInterviewSentRepository->findBySpeakerAndEvent($speaker, $event);
        }

        return new Response($this->renderer->render('speaker/show.html.twig', [
            'speaker' => $speaker,
            'sendInterview' => $sendInterview ?? null,
            'attendingEvents' => $attendingEvents,
        ]));
    }
}
