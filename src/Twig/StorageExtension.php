<?php

declare(strict_types=1);

namespace App\Twig;

use Gaufrette\Extras\Resolvable\ResolverInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\Asset\Packages;

final class StorageExtension extends AbstractExtension
{
    private $awsS3PublicUrlResolver;
    private const AUTHORIZED_SCHEMA_REGEX = '/^(https?:\/\/)/';
    private $assetsHelper;

    public function __construct(ResolverInterface $awsS3PublicUrlResolver, Packages $assetsHelper)
    {
        $this->awsS3PublicUrlResolver = $awsS3PublicUrlResolver;
        $this->assetsHelper = $assetsHelper;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('storage_url', [$this, 'formatUrl']),
        ];
    }

    public function formatUrl(string $path): string
    {
        if (preg_match(self::AUTHORIZED_SCHEMA_REGEX, $path)) {
            return $this->assetsHelper->getUrl('/images/default_speaker.svg');
        } else {
            return $this->awsS3PublicUrlResolver->resolve($path);
        }
    }
}
