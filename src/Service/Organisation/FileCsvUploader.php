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

    public function __construct(OrganisationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function read(string $pathName): Reader
    {
        $reader = Reader::createFromPath($pathName, 'r');
        $records = (new Statement())->process($reader);
        if (0 === count($records)) {
            throw new LogicException('An empty file is not allowed');
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
