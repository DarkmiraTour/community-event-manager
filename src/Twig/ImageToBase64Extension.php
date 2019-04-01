<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ImageToBase64Extension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('base64_image_from_storage', [
                ImageToBase64Runtime::class,
                'imageToBase64',
            ]),
        ];
    }
}
