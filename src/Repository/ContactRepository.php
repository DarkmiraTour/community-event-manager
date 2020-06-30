<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\ContactRequest;
use App\Entity\Address;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ContactRepository implements ContactRepositoryInterface
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Contact::class);
    }

    public function save(Contact $contact): void
    {
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

    public function remove(Contact $contact): void
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();
    }

    public function find(string $id): ?Contact
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function createFromRequest(ContactRequest $contactRequest): Contact
    {
        $contact = new Contact();

        return $contact
            ->setId($this->nextIdentity()->toString())
            ->setFirstName($this->firstName)
            ->setLastName($this->lastName)
            ->setEmail($this->email)
            ->setPhoneNumber($this->phoneNumber)
            ->setAddresses($this->addresses)
        ;
    }

    public function createWith(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber,
        Address $address
    ): Contact {
        $contact = new Contact();

        return $contact
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
            ->addAddress($address)
        ;
    }

    public function nextIdentity(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
