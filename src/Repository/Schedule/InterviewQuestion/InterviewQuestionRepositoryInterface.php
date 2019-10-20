<?php

declare(strict_types=1);

namespace App\Repository\Schedule\InterviewQuestion;

use App\Entity\InterviewQuestion;

interface InterviewQuestionRepositoryInterface
{
    public function createInterviewQuestion(string $question): InterviewQuestion;

    public function save(InterviewQuestion $interviewQuestion): void;

    public function remove(InterviewQuestion $interviewQuestion): void;

    /**
     * @param int|null $lockMode
     * @param int|null $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?InterviewQuestion;

    public function findAll(): array;
}
