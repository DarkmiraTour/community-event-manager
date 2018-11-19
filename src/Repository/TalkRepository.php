<?php declare(strict_types=1);

namespace App\Repository;

use App\Dto\TalkRequest;
use App\Entity\Talk;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class TalkRepository implements TalkRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Talk::class);
    }

    public function save(Talk $talk): void
    {
        $this->entityManager->persist($talk);
        $this->entityManager->flush();
    }

    public function remove(Talk $talk): void
    {
        $this->entityManager->remove($talk);
        $this->entityManager->flush();
    }

    public function find(string $id): ?Talk
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function createFromRequest(TalkRequest $talkRequest): Talk
    {
        return new Talk(
            $this->nextIdentity(),
            $talkRequest->title,
            $talkRequest->description,
            $talkRequest->speaker
        );
    }
}
