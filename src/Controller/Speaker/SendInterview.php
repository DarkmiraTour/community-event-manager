<?php

declare(strict_types=1);

namespace App\Controller\Speaker;

use App\Dto\InterviewRequest;
use App\Form\InterviewType;
use App\Repository\SpeakerRepositoryInterface;
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
    private $formFactory;
    private $router;
    private $interviewService;

    public function __construct(
        Twig $renderer,
        SpeakerRepositoryInterface $speakerRepository,
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        InterviewService $interviewService
    ) {
        $this->renderer = $renderer;
        $this->speakerRepository = $speakerRepository;
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
        $speaker = $this->speakerRepository->find($id);

        $interviewRequest = new InterviewRequest();

        $form = $this->formFactory->create(InterviewType::class, $interviewRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionList = $this->interviewService->filterQuestions($interviewRequest);
            $mailerSuccess = $this->interviewService->sendInterviewEmail($speaker, $questionList);

            if (self::SEND_MAIL_SUCCESSFUL === $mailerSuccess) {
                $speaker->confirmInterviewIsSent();
                $this->speakerRepository->save($speaker);
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
