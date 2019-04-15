<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class SpecialBenefit
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationSponsor", mappedBy="specialBenefit")
     */
    private $organisationSponsors;

    public function __construct(UuidInterface $id, string $label, float $price, string $description)
    {
        $this->id = $id->toString();
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
        $this->organisationSponsors = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function updateSpecialBenefit(string $label, float $price, string $description): void
    {
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
    }

    public function getOrganisationSponsors(): Collection
    {
        return $this->organisationSponsors;
    }

    public function addOrganisationSponsor(OrganisationSponsor $organisationSponsor): void
    {
        $this->organisationSponsors->add($organisationSponsor);
    }
}
