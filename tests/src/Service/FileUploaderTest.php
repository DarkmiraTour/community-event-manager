<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\FileUploader;
use Gaufrette\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

final class FileUploaderTest extends TestCase
{
    private $filesystemProphecy;
    private $fileUploader;

    public function setUp(): void
    {
        $this->filesystemProphecy = $this->prophesize(FilesystemInterface::class);

        $this->fileUploader = new FileUploader(
            $this->filesystemProphecy->reveal()
        );
    }

    public function testFileIsUploaded(): void
    {
        $this->filesystemProphecy->write(Argument::any(), Argument::any())->shouldBeCalled();

        $this->fileUploader->upload(new File(__DIR__.'/../../resources/emptyFile', false));
    }
}
