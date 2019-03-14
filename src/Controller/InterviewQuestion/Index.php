<?php

declare(strict_types=1);

namespace App\Controller\InterviewQuestion;

use App\Repository\Schedule\InterviewQuestion\InterviewQuestionManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment as Twig;

/**
 * @Security("is_granted('ROLE_USER')")
 */
final class Index
{
    private $renderer;
    private $interviewQuestionManager;

    public function __construct(
        Twig $renderer,
        InterviewQuestionManagerInterface $interviewQuestionManager
    ) {
        $this->renderer = $renderer;
        $this->interviewQuestionManager = $interviewQuestionManager;
    }

    public function handle(): Response
    {
        return new Response($this->renderer->render('schedule/interviewQuestion/index.html.twig', [
            'interviewQuestions' => $this->interviewQuestionManager->findAll(),
        ]));
    }
}
