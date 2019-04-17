<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class used to implement many to many between Speaker and Event with the information about the interview
 * (one interview can only be sent to one speaker for one event).
 *
 * @ORM\Entity()
 * @ORM\Table(name="speaker_event_interview_sent")
 */
class SpeakerEventInterviewSent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Speaker")
     */
    private $speaker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     */
    private $interviewSent = false;

    public function __construct(Speaker $speaker, Event $event)
    {
        $this->speaker = $speaker;
        $this->event = $event;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getSpeaker(): Speaker
    {
        return $this->speaker;
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
}
