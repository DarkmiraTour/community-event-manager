<?php

declare(strict_types=1);

namespace App\Service\Organisation;

use App\Entity\Organisation;
use App\Repository\Organisation\OrganisationRepositoryInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Process\Exception\LogicException;

final class FileCsvUploader implements FileCsvUploaderInterface
{
    private $repository;
    private $csvHeaderFormat;

    public function __construct(OrganisationRepositoryInterface $repository, array $csvHeaderFormat)
    {
        $this->repository = $repository;
        $this->csvHeaderFormat = $csvHeaderFormat;
    }

    public function read(string $pathName): Reader
    {
        $reader = Reader::createFromPath($pathName, 'r');
        $records = (new Statement())->process($reader);
        if (0 === count($records)) {
            throw new LogicException('An empty file is not allowed');
        }

        if ($this->csvHeaderFormat !== $reader->fetchOne()) {
            throw new LogicException('Headers do not match: '.implode(', ', array_diff($this->csvHeaderFormat,$reader->fetchOne())));
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

            $this->repository->save($organisation);
        }
    }
}
