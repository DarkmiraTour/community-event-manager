<?php

declare(strict_types=1);

namespace App\Organisation\Upload;

use App\Organisation\Organisation;
use Symfony\Component\EventDispatcher\Event;

class OrganisationImportEvent extends Event
{
    public const ORGANISATION_IMPORTED = 'organisation.imported';

    private $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }
}
