<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\InterviewRequest;
use App\Form\InterviewType;
use App\Repository\SpeakerEventInterviewSent\SpeakerEventRepositoryInterface;
use App\Repository\SpeakerRepositoryInterface;
use App\Service\Event\EventServiceInterface;
use App\Service\Interview\InterviewService;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

final class SendInterview
{
    private const SEND_MAIL_SUCCESSFUL = 1;
    private $renderer;
    private $speakerRepository;
    private $eventService;
    private $speakerEventRepository;
    private $formFactory;
    private $router;
    private $interviewService;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        EventServiceInterface $eventService,
        SpeakerEventRepositoryInterface $speakerEventRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        InterviewService $interviewService
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
        $this->eventService = $eventService;
        $this->speakerEventRepository = $speakerEventRepository;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->interviewService = $interviewService;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function handle(Request $request): Response
    {
        $id = Uuid::fromString($request->attributes->get('id'))->toString();

        $event = $this->eventService->getSelectedEvent();

        $speaker = $this->speakerRepository->find($id);

        $speakerEvent = $this->speakerEventRepository->findBySpeakerAndEvent($speaker, $event);

        $interviewRequest = new InterviewRequest();

        $form = $this->formFactory->create(InterviewType::class, $interviewRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionList = $this->interviewService->filterQuestions($interviewRequest);
            $mailerSuccess = $this->interviewService->sendInterviewEmail($speaker, $event, $questionList);

            if (self::SEND_MAIL_SUCCESSFUL === $mailerSuccess) {
                $speakerEvent->confirmInterviewIsSent();
                $this->speakerEventRepository->save($speakerEvent);
            }

            return new RedirectResponse($this->router->generate('speaker_show', [
                'id' => $speaker->getId(),
            ]));
        }

        return new Response($this->renderer->render('interview/create.html.twig', [
            'form' => $form->createView(),
            'speaker' => $speaker,
        ]));
    }
}
