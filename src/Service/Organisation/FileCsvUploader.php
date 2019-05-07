<?php

declare(strict_types=1);

namespace App\Service\Organisation;

use App\Entity\Organisation;
use App\Event\Organisation\OrganisationImportEvent;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class FileCsvUploader implements FileCsvUploaderInterface
{
    private $repository;
    private $csvHeaderFormat;
    private $eventDispatcher;

    public function __construct(OrganisationRepositoryInterface $repository, array $csvHeaderFormat, EventDispatcherInterface $eventDispatcher)
    {
        $this->repository = $repository;
        $this->csvHeaderFormat = $csvHeaderFormat;
        $this->eventDispatcher = $eventDispatcher;
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
                null,
                $record['comment']
            );
            $this->eventDispatcher->dispatch(OrganisationImportEvent::ORGANISATION_IMPORTED, new OrganisationImportEvent($organisation));
        }
    }
}
