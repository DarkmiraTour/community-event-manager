<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\AddressRequest;
use App\Entity\Address;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AddressRepository implements AddressRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Address::class);
    }

    public function save(Address $address): void
    {
        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }

    public function remove(Address $address): void
    {
        $this->entityManager->remove($address);
        $this->entityManager->flush();
    }

    public function find(string $id): ?Address
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFromRequest(AddressRequest $addressRequest): Address
    {
        $address = new Address(
            $this->nextIdentity()->toString(),
            $this->streetAddress,
            $this->streetAddressComplementary,
            $this->postalCode,
            $this->city
        );

        return $address;
    }

    public function createWith(
        string $streetAddress,
        string $streetAddressComplementary,
        string $postalCode,
        string $city
    ): Address {
        $address = new Address(
            $this->nextIdentity()->toString(),
            $streetAddress,
            $streetAddressComplementary,
            $postalCode,
            $city
        );

        return $address;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
