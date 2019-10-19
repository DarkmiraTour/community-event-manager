<?php

declare(strict_types=1);

namespace App\Speaker;

use App\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Speaker
{
    private $id;
    private $name;
    private $title;
    private $email;
    private $biography;
    private $photo;
    private $twitter;
    private $facebook;
    private $linkedin;
    private $github;
    private $talks;
    private $events;
    private $interviewSent = false;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $title,
        string $email,
        string $biography,
        string $photo,
        string $twitter = null,
        string $facebook = null,
        string $linkedin = null,
        string $github = null
    ) {
        $this->id = $id->toString();
        $this->name = $name;
        $this->title = $title;
        $this->email = $email;
        $this->biography = $biography;
        $this->photo = $photo;
        $this->twitter = $twitter;
        $this->facebook = $facebook;
        $this->linkedin = $linkedin;
        $this->github = $github;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function isInterviewSent(): bool
    {
        return $this->interviewSent;
    }

    public function confirmInterviewIsSent(): void
    {
        $this->interviewSent = true;
    }

    public function confirmInterviewNotSent(): void
    {
        $this->interviewSent = false;
    }

    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addAttendingEvent(Event $event): void
    {
        $this->events->add($event);
    }
}
