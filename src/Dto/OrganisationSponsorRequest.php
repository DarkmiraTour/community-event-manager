<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\OrganisationSponsor;
use App\Entity\SpecialBenefit;
use App\Entity\SponsorshipLevel;

final class OrganisationSponsorRequest
{
    public $organisation;
    public $event;
    public $specialBenefit;
    public $sponsorshipLevel;

    public function __construct(?SpecialBenefit $specialBenefit = null, ?SponsorshipLevel $sponsorshipLevel = null)
    {
        $this->specialBenefit = $specialBenefit;
        $this->sponsorshipLevel = $sponsorshipLevel;
    }

    public static function createFrom(OrganisationSponsor $organisationSponsor): OrganisationSponsorRequest
    {
        return new OrganisationSponsorRequest(
            $organisationSponsor->getSpecialBenefit(),
            $organisationSponsor->getSponsorshipLevel()
        );
    }

    public function updateOrganisationSponsor(OrganisationSponsor $organisationSponsor): OrganisationSponsor
    {
        $organisationSponsor->setSpecialBenefit($this->specialBenefit);
        $organisationSponsor->setSponsorshipLevel($this->sponsorshipLevel);

        return $organisationSponsor;
    }
}
