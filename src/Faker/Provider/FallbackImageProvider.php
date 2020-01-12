<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use Throwable;

final class FallbackImageProvider implements Image
{
    private static $PROVIDERS = [PicsumImage::class];

    public static function image(
        $dir = null,
        $width = 640,
        $height = 480,
        $category = null,
        $fullPath = true,
        $randomize = true,
        $word = null
    ) {
        $providers = self::$PROVIDERS;
        while ($provider = array_shift($providers)) {
            try {
                $result = $provider::image($dir, $width, $height, $category, $fullPath, $randomize, $word);
            } catch (Throwable $exception) {
                $result = false;
            }
            if (false !== $result) {
                return $result;
            }
        }

        return false;
    }
}
