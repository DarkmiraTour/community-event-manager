<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\ContactRequest;
use App\Entity\Address;
use App\Entity\Contact;
use Ramsey\Uuid\UuidInterface;

interface ContactRepositoryInterface
{
    public function save(Contact $contact): void;

    public function find(string $id): ?Contact;

    public function remove(Contact $contact): void;

    public function findAll(): array;

    public function nextIdentity(): UuidInterface;

    public function createFromRequest(ContactRequest $contactRequest): Contact;

    public function createWith(string $firstName, string $lastName, string $email, string $phoneNumber, Address $address): Contact;
}
