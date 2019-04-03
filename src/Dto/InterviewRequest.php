<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class InterviewRequest
{
    public const MIN_QUESTION_NUMBER = 1;
    public const MAX_QUESTION_NUMBER = 5;
    public $preFilledQuestion1;
    public $preFilledQuestion2;
    public $preFilledQuestion3;
    public $preFilledQuestion4;
    public $preFilledQuestion5;
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    public $customQuestion1;
    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    public $customQuestion2;
    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    public $customQuestion3;
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    public $customQuestion4;
    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    public $customQuestion5;

    public function getQuestion(int $number): ?string
    {
        $customQuestionParameterName = "customQuestion{$number}";
        $preFilledQuestionParameterName = "preFilledQuestion{$number}";

        if (null === $this->{$preFilledQuestionParameterName} && null === $this->{$customQuestionParameterName}) {
            return null;
        }

        if (null === $this->{$customQuestionParameterName}) {
            return $this->{$preFilledQuestionParameterName}->getQuestion();
        }

        return $this->{$customQuestionParameterName};
    }
}
