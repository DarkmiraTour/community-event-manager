<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use function copy;
use function curl_close;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt;
use Faker\Provider\Base;
use function fclose;
use function fopen;
use function function_exists;
use function http_build_query;
use function ini_get;
use InvalidArgumentException;
use function is_dir;
use function is_null;
use function is_writable;
use function md5;
use RuntimeException;
use function sprintf;
use function sys_get_temp_dir;
use function uniqid;
use function unlink;

final class PicsumImage extends Base
{
    /**
     * Generate the URL that will return a random image.
     *
     * Set randomize to false to remove the random GET parameter at the end of the url.
     *
     * @example 'https://picsum.photos/640/480/?random=1'
     *
     * @param int         $width
     * @param int         $height
     * @param string|null $category  will throw an error if set
     * @param bool        $randomize
     * @param string|null $word      will throw an error if set
     * @param bool        $gray
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function imageUrl($width = 640, $height = 480, $category = null, $randomize = true, $word = null, $gray = false)
    {
        $baseUrl = 'https://picsum.photos/';
        $url = "{$width}/{$height}/";
        $queryParams = [];

        if ($gray) {
            $queryParams['grayscale'] = 1;
        }

        if ($category) {
            throw new InvalidArgumentException('Do not use the category setting with picsum.');
        }

        if ($word) {
            throw new InvalidArgumentException('Do not use the word setting with picsum.');
        }

        if ($randomize) {
            $queryParams['random'] = 1;
        }

        return $baseUrl.$url.'?'.http_build_query($queryParams);
    }

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
    public static function image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null)
    {
        $dir = is_null($dir) ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name.'.jpg';
        $filepath = $dir.DIRECTORY_SEPARATOR.$filename;

        $url = static::imageUrl($width, $height, $category, $randomize, $word);

        // save file
        if (function_exists('curl_exec')) {
            $filepath = static::curlImage($filepath, $url);

            return $fullPath ? $filepath : $filename;
        }

        if (ini_get('allow_url_fopen')) {
            // use remote fopen() via copy()
            copy($url, $filepath);

            return $fullPath ? $filepath : $filename;
        }

        return new RuntimeException('The image formatter downloads an image from a remote HTTP server. Therefore, it requires that PHP can request remote hosts, either via cURL or fopen()');
    }

    private static function curlImage(string $filepath, string $url)
    {
        // use cURL
        $file = fopen($filepath, 'w');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FILE, $file);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $success = curl_exec($curl) && curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200;
        fclose($file);
        curl_close($curl);

        if (!$success) {
            unlink($filepath);
            // could not contact the distant URL or HTTP error - fail silently.
            return false;
        }

        return $filepath;
    }
}
