<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Address;
use Symfony\Component\Validator\Constraints as Assert;

final class AddressRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $streetAddress;

    public $streetAddressComplementary;

    /**
     * @Assert\NotBlank()
     */
    public $postalCode;

    /**
     * @Assert\NotBlank()
     */
    public $city;

    public static function createFromEntity(Address $address): AddressRequest
    {
        $addressRequest = new self();
        $addressRequest->streetAddress = $address->getStreetAddress();
        $addressRequest->streetAddressComplementary = $address->getStreetAddressComplementary();
        $addressRequest->postalCode = $address->getPostalCode();
        $addressRequest->city = $address->getCity();

        return $addressRequest;
    }

    public function updateEntity(Address $address): void
    {
        $address->setStreetAddress($this->streetAddress);
        $address->setStreetAddressComplementary($this->streetAddressComplementary);
        $address->setPostalCode($this->postalCode);
        $address->setCity($this->city);
    }
}
