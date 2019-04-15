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
class Organisation
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", cascade={"persist"})
     */
    private $contact;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", cascade={"persist", "remove"})
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrganisationSponsor", mappedBy="organisation")
     */
    private $organisationSponsors;

    public function __construct(UuidInterface $id, string $name, string $website, Contact $contact = null, string $comment = null)
    {
        $this->id = $id->toString();
        $this->name = $name;
        $this->website = $website;
        $this->contact = $contact;
        $this->comment = $comment;
        $this->events = new ArrayCollection();
        $this->organisationSponsors = new ArrayCollection();
    }

    public function getId(): ?string
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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addSponsoredEvent(Event $event): void
    {
        $this->events->add($event);
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
