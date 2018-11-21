<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * Address name (Headquarter, personnal address...).
     *
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=127)
     */
    private $streetAddress;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $streetAddressComplementary;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=15)
     */
    private $postalCode;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=63)
     */
    private $city;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreetAddress(): ?string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function getStreetAddressComplementary(): ?string
    {
        return $this->streetAddressComplementary;
    }

    public function setStreetAddressComplementary(?string $streetAddressComplementary): self
    {
        $this->streetAddressComplementary = $streetAddressComplementary;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
