<?php

declare(strict_types=1);

namespace App\Organisation\Upload;

use App\Organisation\Organisation;
use App\Organisation\OrganisationRepositoryInterface;
use App\Repository\AddressRepositoryInterface;
use App\Repository\ContactRepositoryInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Process\Exception\LogicException;

final class FileCsvUploader implements FileCsvUploaderInterface
{
    private $repository;
    private $csvHeaderFormat;
    private $eventDispatcher;
    private $contactRepository;
    private $addressRepository;

    public function __construct(
        OrganisationRepositoryInterface $repository,
        array $csvHeaderFormat,
        EventDispatcherInterface $eventDispatcher,
        ContactRepositoryInterface $contactRepository,
        AddressRepositoryInterface $addressRepository
    ) {
        $this->repository = $repository;
        $this->csvHeaderFormat = $csvHeaderFormat;
        $this->eventDispatcher = $eventDispatcher;
        $this->contactRepository = $contactRepository;
        $this->addressRepository = $addressRepository;
    }

    public function read(string $pathName): Reader
    {
        $reader = Reader::createFromPath($pathName, 'r');
        $records = (new Statement())->process($reader);
        if (0 === count($records)) {
            throw new LogicException('An empty file is not allowed');
        }
        if ($this->csvHeaderFormat !== $reader->fetchOne()) {
            throw new LogicException('Headers do not match: '.implode(', ', array_diff($this->csvHeaderFormat, $reader->fetchOne())));
        }

        return $reader->setHeaderOffset(0);
    }

    public function import(Reader $csvData): void
    {
        foreach ($csvData as $record) {
            $organisation = new Organisation(
                $this->repository->nextIdentity(),
                $record['name'],
                $record['website'],
                $this->contactRepository->createWith(
                    $record['contact_first_name'],
                    $record['contact_last_name'],
                    $record['contact_email'],
                    $record['contact_phone_number'],
                    $this->addressRepository->createWith(
                        $record['address_name'],
                        $record['street_address'],
                        $record['street_address_complementary'],
                        $record['postal_code'],
                        $record['city']
                    )
                ),
                $record['comment']
            );
            $this->eventDispatcher->dispatch(OrganisationImportEvent::ORGANISATION_IMPORTED, new OrganisationImportEvent($organisation));
        }
    }
}
