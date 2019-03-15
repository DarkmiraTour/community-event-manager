<?php

declare(strict_types=1);

namespace App\Repository\Schedule\InterviewQuestion;

use App\Entity\InterviewQuestion;
use App\Dto\InterviewQuestionRequest;
use App\Exceptions\InterviewQuestionNotFoundException;

final class InterviewQuestionManager implements InterviewQuestionManagerInterface
{
    private $repository;

    public function __construct(InterviewQuestionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find(string $id): InterviewQuestion
    {
        return $this->checkEntity($this->repository->find($id));
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFrom(InterviewQuestionRequest $interviewQuestionRequest): InterviewQuestion
    {
        return $this->repository->createInterviewQuestion($interviewQuestionRequest->question);
    }

    public function createWith(string $question): InterviewQuestion
    {
        return $this->repository->createInterviewQuestion($question);
    }

    public function save(InterviewQuestion $interviewQuestion): void
    {
        $this->repository->save($interviewQuestion);
    }

    public function remove(InterviewQuestion $interviewQuestion): void
    {
        $this->repository->remove($interviewQuestion);
    }

    private function checkEntity(?InterviewQuestion $interviewQuestion): InterviewQuestion
    {
        if (!$interviewQuestion) {
            throw new InterviewQuestionNotFoundException();
        }

        return $interviewQuestion;
    }
}
