<?php

declare(strict_types=1);

namespace App\Repository\Schedule\InterviewQuestion;

use App\Entity\InterviewQuestion;
use App\Dto\InterviewQuestionRequest;

interface InterviewQuestionManagerInterface
{
    public function find(string $id): InterviewQuestion;

    public function findAll(): array;

    public function createFrom(InterviewQuestionRequest $interviewQuestionRequest): InterviewQuestion;

    public function createWith(string $position): InterviewQuestion;

    public function save(InterviewQuestion $interviewQuestion): void;

    public function remove(InterviewQuestion $interviewQuestion): void;
}
