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
     * @param mixed    $id
     * @param int|null $lockMode
     * @param int|null $lockVersion
     *
     * @return InterviewQuestion|null
     */
    public function find($id, $lockMode = null, $lockVersion = null): ?InterviewQuestion;

    public function findAll(): array;
}
