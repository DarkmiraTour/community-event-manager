<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Contact;
use Symfony\Component\Validator\Constraints as Assert;

final class ContactRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $firstName;

    public $lastName;

    /**
     * @Assert\Email()
     */
    public $email;

    public $phoneNumber;

    public $addresses;

    public static function createFromEntity(Contact $contact): ContactRequest
    {
        $contactRequest = new self();
        $contactRequest->firstName = $contact->getFirstName();
        $contactRequest->lastName = $contact->getLastName();
        $contactRequest->email = $contact->getEmail();
        $contactRequest->phoneNumber = $contact->getPhoneNumber();
        $contactRequest->addresses = $contact->getAddresses();

        return $contactRequest;
    }

    public function updateEntity(Contact $contact): void
    {
        $contact->setFirstName($this->firstName);
        $contact->setLastName($this->lastName);
        $contact->setEmail($this->email);
        $contact->setPhoneNumber($this->phoneNumber);
        $contact->setAddresses($this->addresses);
    }
}
