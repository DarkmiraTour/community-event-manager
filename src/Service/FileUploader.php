<?php

declare(strict_types=1);

namespace App\Service;

use Gaufrette\FilesystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

final class FileUploader implements FileUploaderInterface
{
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(File $file): string
    {
        $filename = Uuid::uuid4()->toString().'.'.$file->guessExtension();

        $this->filesystem->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function get(string $fileName): string
    {
        return $this->filesystem->read($fileName);
    }

    public function getOriginalFileExtension(string $file): string
    {
        return substr(strrchr($file, '.'), 1);
    }
}
