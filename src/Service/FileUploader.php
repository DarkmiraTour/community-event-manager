<?php declare(strict_types=1);

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

    public function upload(File $file): File
    {
        $filename = Uuid::uuid4()->toString() . '.' . $file->guessExtension();

        $this->filesystem->write($filename, file_get_contents($file->getPathname()));

        return new File($filename, false);
    }
}
