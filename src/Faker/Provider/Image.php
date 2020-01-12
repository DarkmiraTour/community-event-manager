<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use RuntimeException;

interface Image
{
    /**
     * Download a remote random image to disk and return its location.
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @param null $dir
     * @param int  $width
     * @param int  $height
     * @param null $category
     * @param bool $fullPath
     * @param bool $randomize
     * @param null $word
     *
     * @return bool|RuntimeException|string
     *
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
    public static function image(
        $dir = null,
        $width = 640,
        $height = 480,
        $category = null,
        $fullPath = true,
        $randomize = true,
        $word = null
    );
}
