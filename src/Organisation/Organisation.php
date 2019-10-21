<?php

declare(strict_types=1);

namespace App\Organisation;

use App\Entity\Contact;
use App\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Organisation
{
    private $id;
    /**
     * @Assert\NotBlank()
     */
    private $name;
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    private $website;
    private $contact;
    private $comment;
    private $events;

    public function __construct(UuidInterface $id, string $name, string $website, Contact $contact = null, string $comment = null)
    {
        $this->id = $id->toString();
        $this->name = $name;
        $this->website = $website;
        $this->contact = $contact;
        $this->comment = $comment;
        $this->events = new ArrayCollection();
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
}
