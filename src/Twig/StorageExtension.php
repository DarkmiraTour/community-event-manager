<?php

declare(strict_types=1);

namespace App\Twig;

use Gaufrette\Extras\Resolvable\ResolverInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\Templating\Helper\AssetsHelper;

final class StorageExtension extends AbstractExtension
{
    private $awsS3PublicUrlResolver;
    private const AUTHORIZED_SCHEMA_REGEX = '/^(https?:\/\/)/';

    public function __construct(ResolverInterface $awsS3PublicUrlResolver)
    {
        $this->awsS3PublicUrlResolver = $awsS3PublicUrlResolver;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('storage_url', [$this, 'formatUrl']),
        ];
    }

    public function formatUrl(string $path, AssetsHelper $assetsHelper): string
    {
        // dump( preg_match(self::AUTHORIZED_SCHEMA_REGEX, $path) );

        if (preg_match(self::AUTHORIZED_SCHEMA_REGEX, $path)) {
            $assetsPath = $assetsHelper->getUrl('/images/default_speaker.svg');
        } else {
            return $this->awsS3PublicUrlResolver->resolve($path);
        }
    }
}
