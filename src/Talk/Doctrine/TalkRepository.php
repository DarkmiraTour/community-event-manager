<?php

declare(strict_types=1);

namespace App\Talk\Doctrine;

use App\Talk\Talk;
use App\Talk\TalkRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class TalkRepository implements TalkRepositoryInterface
{
    private $entityManager;
    /** @var ObjectRepository */
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
}
