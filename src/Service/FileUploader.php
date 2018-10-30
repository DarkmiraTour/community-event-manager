<?php

namespace App\Service;

use Gaufrette\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(File $file)
    {
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        $this->filesystem->write($filename, file_get_contents($file->getPathname()));

        return new File($filename, false);
    }
}
