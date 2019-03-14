<?php

declare(strict_types=1);

namespace App\Repository\Schedule\InterviewQuestion;

use App\Entity\InterviewQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class InterviewQuestionRepository extends ServiceEntityRepository implements InterviewQuestionRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InterviewQuestion::class);
    }

    public function createInterviewQuestion(string $position): InterviewQuestion
    {
        return new InterviewQuestion(
            $this->nextIdentity(),
            $position
        );
    }

    public function save(InterviewQuestion $interviewQuestion): void
    {
        $this->getEntityManager()->persist($interviewQuestion);
        $this->getEntityManager()->flush();
    }

    public function remove(InterviewQuestion $interviewQuestion): void
    {
        $this->getEntityManager()->remove($interviewQuestion);
        $this->getEntityManager()->flush();
    }

    public function find($id, $lockMode = null, $lockVersion = null): ?InterviewQuestion
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @return UuidInterface
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    private function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
