<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Repository\SpeakerEventInterviewSent\SpeakerEventRepositoryInterface;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

final class Index
{
    private $renderer;
    private $speakerRepository;
    private $speakerEventRepository;
    private $eventService;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        SpeakerEventRepositoryInterface $speakerEventRepository,
        EventServiceInterface $eventService
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->speakerEventRepository = $speakerEventRepository;
        $this->eventService = $eventService;
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function handle(): Response
    {
        $speakers = $this->getSpeakerList();

        return new Response($this->renderer->render('speaker/index.html.twig', [
            'speakers' => $speakers,
        ]));
    }

    private function getSpeakerList(): array
    {
        if ($this->eventService->isEventSelected()) {
            return $this->speakerEventRepository->findAllSpeakersByEvent($this->eventService->getSelectedEvent());
        }

        return $this->speakerRepository->findAll();
    }
}
