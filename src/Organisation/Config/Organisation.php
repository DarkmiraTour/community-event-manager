<?php

declare(strict_types=1);

namespace App\Organisation\Config;

final class Organisation
{
    private $maxListOrganisationEntries;

    public function __construct(int $maxListOrganisationEntries)
    {
        $this->maxListOrganisationEntries = $maxListOrganisationEntries;
    }

    public function getMaxListOrganisationEntries(): int
    {
        return $this->maxListOrganisationEntries;
    }
}
