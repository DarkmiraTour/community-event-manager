<?php

declare(strict_types=1);

namespace App\Speaker\Interview;

use App\Speaker\Speaker;
use Twig\Environment as Twig;

final class InterviewService
{
    private $mailer;
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Twig $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function filterQuestions(InterviewRequest $interviewRequest): array
    {
        $questionList = [];
        for ($i = InterviewRequest::MIN_QUESTION_NUMBER; $i <= InterviewRequest::MAX_QUESTION_NUMBER; $i++) {
            if ($question = $interviewRequest->getQuestion($i)) {
                $questionList[] = $question;
            }
        }

        return $questionList;
    }

    public function getMailer(): \Swift_Mailer
    {
        return $this->mailer;
    }

    public function sendInterviewEmail(Speaker $speaker, array $questionList): int
    {
        $message = (new \Swift_Message('Your interview'))
            ->setFrom('no-reply-admin-cem@gmail.com')
            ->setTo($speaker->getEmail())
            ->setBody(
                $this->renderer->render('interview/send-email.html.twig',
                    [
                        'questionList' => $questionList,
                        'speaker' => $speaker,
                    ]),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}
