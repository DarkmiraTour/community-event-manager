<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\InterviewQuestion;
use Symfony\Component\Validator\Constraints as Assert;

final class InterviewQuestionRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(max="255")
     */
    public $question;

    public static function createFromInterviewQuestion(InterviewQuestion $interviewQuestion): InterviewQuestionRequest
    {
        $interviewQuestionRequest = new self();
        $interviewQuestionRequest->question = $interviewQuestion->getQuestion();

        return $interviewQuestionRequest;
    }

    public function updateInterviewQuestion(InterviewQuestion $interviewQuestion): void
    {
        $interviewQuestion->updateInterviewQuestion($this->question);
    }
}
