<?php

declare(strict_types=1);

namespace App\Organisation\Upload;

use League\Csv\Reader;

interface FileCsvUploaderInterface
{
    public function read(string $pathName): Reader;

    public function import(Reader $csvData): void;
}
