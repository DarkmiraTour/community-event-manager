<?php

declare(strict_types=1);

namespace App\Twig;

use Gaufrette\Extras\Resolvable\ResolverInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class StorageExtension extends AbstractExtension
{
    private $awsS3PublicUrlResolver;

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

    public function formatUrl(string $path): string
    {
        return $this->awsS3PublicUrlResolver->resolve($path);
    }
}
