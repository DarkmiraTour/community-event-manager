<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Organisation;
use Symfony\Component\Validator\Constraints as Assert;

final class OrganisationRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public $website;

    public $address;

    public $comment;

    public function __construct(string $name = null, string $website = null, string $address = null, string $comment = null)
    {
        $this->name = $name;
        $this->website = $website;
        $this->address = $address;
        $this->comment = $comment;
    }

    public static function createFrom(Organisation $organisation): OrganisationRequest
    {
        return new OrganisationRequest(
            $organisation->getName(),
            $organisation->getWebsite(),
            $organisation->getAddress(),
            $organisation->getComment()
        );
    }

    public function updateOrganisation(Organisation $organisation): void
    {
        $organisation->setName($this->name);
        $organisation->setWebsite($this->website);
        $organisation->setAddress($this->address);
        $organisation->setComment($this->comment);
    }
}
