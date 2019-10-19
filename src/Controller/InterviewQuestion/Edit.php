<?php

declare(strict_types=1);

namespace App\Controller\InterviewQuestion;

use App\Dto\InterviewQuestionRequest;
use App\Form\InterviewQuestionType;
use App\Repository\Schedule\InterviewQuestion\InterviewQuestionManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
final class Edit
{
    private $renderer;
    private $interviewQuestionManager;
    private $formFactory;
    private $router;

    public function __construct(
        Twig $renderer,
        InterviewQuestionManagerInterface $interviewQuestionManager,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->renderer = $renderer;
        $this->interviewQuestionManager = $interviewQuestionManager;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $interviewQuestion = $this->interviewQuestionManager->find($request->attributes->get('id'));
        $interviewQuestionRequest = InterviewQuestionRequest::createFromInterviewQuestion($interviewQuestion);

        $form = $this->formFactory->create(InterviewQuestionType::class, $interviewQuestionRequest, [
            'method' => Request::METHOD_PUT,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interviewQuestionRequest = $form->getData();
            $interviewQuestionRequest->updateInterviewQuestion($interviewQuestion);
            $this->interviewQuestionManager->save($interviewQuestion);

            return new RedirectResponse($this->router->generate('interview_question_index'));
        }

        return new Response($this->renderer->render('schedule/interviewQuestion/edit.html.twig', [
            'interviewQuestion' => $interviewQuestion,
            'form' => $form->createView(),
        ]));
    }
}
