<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use App\Service\FileUploaderInterface;

final class ImageToBase64Runtime implements RuntimeExtensionInterface
{
    private $fileUploader;

    public function __construct(FileUploaderInterface $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    public function imageToBase64(string $data): string
    {
        $type = $this->fileUploader->getOriginalFileExtension($data);
        $image = $this->fileUploader->get($data);
        $imageBase64 = base64_encode($image);

        return sprintf('data:image/%s;base64,%s', $type, $imageBase64);
    }
}
