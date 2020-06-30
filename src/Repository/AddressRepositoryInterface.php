<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\AddressRequest;
use App\Entity\Address;
use Ramsey\Uuid\UuidInterface;

interface AddressRepositoryInterface
{
    public function save(Address $address): void;

    public function find(string $id): ?Address;

    public function remove(Address $address): void;

    public function findAll(): array;

    public function nextIdentity(): UuidInterface;

    public function createFromRequest(AddressRequest $addressRequest): Address;

    public function createWith(string $name, string $streetAddress, string $streetAddressComplementary, string $postalCode, string $city): Address;
}
