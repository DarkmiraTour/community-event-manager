<?php

namespace App\Repository\Organisation;

use App\Entity\Organisation;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DoctrineOrganisationRepository implements OrganisationRepositoryInterface
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Organisation::class);
    }

    public function find(string $id): ?Organisation
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function save(Organisation $organisation): void
    {
        $this->em->persist($organisation);
        $this->em->flush();
    }

    public function remove(Organisation $organisation): void
    {
        $this->em->remove($organisation);
        $this->em->flush();
    }
}
