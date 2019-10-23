<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\FileUploaderInterface;
use Twig\Extension\RuntimeExtensionInterface;

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
