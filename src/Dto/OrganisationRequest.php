<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Contact;
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

    /**
     * @Assert\NotBlank()
     */
    public $contact;

    public $comment;

    public function __construct(string $name = null, string $website = null, Contact $contact = null, string $comment = null)
    {
        $this->name = $name;
        $this->website = $website;
        $this->contact = $contact;
        $this->comment = $comment;
    }

    public static function createFrom(Organisation $organisation): OrganisationRequest
    {
        return new OrganisationRequest(
            $organisation->getName(),
            $organisation->getWebsite(),
            $organisation->getContact(),
            $organisation->getComment()
        );
    }

    public function updateOrganisation(Organisation $organisation): void
    {
        $organisation->setName($this->name);
        $organisation->setWebsite($this->website);
        $organisation->setContact($this->contact);
        $organisation->setComment($this->comment);
    }
}
