<?php

declare(strict_types=1);

namespace App\Speaker\Doctrine;

use App\Speaker\SpeakerRepositoryInterface;
use App\Speaker\SpeakerRequest;
use App\Speaker\Speaker;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SpeakerRepository implements SpeakerRepositoryInterface
{
    private $repository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Speaker::class);
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function find(string $id): Speaker
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function save(Speaker $speaker): void
    {
        $this->entityManager->persist($speaker);
        $this->entityManager->flush();
    }

    public function remove(Speaker $speaker): void
    {
        $this->entityManager->remove($speaker);
        $this->entityManager->flush();
    }

    public function createFromRequest(SpeakerRequest $speakerRequest): Speaker
    {
        return new Speaker(
            $this->nextIdentity(),
            $speakerRequest->name,
            $speakerRequest->title,
            $speakerRequest->email,
            $speakerRequest->biography,
            $speakerRequest->photoPath,
            $speakerRequest->twitter,
            $speakerRequest->facebook,
            $speakerRequest->linkedin,
            $speakerRequest->github
        );
    }

    public function createWith(string $name, string $email, string $title, string $biography, string $photoPath): Speaker
    {
        return new Speaker(
            $this->nextIdentity(),
            $name,
            $title,
            $email,
            $biography,
            $photoPath
        );
    }
}
