<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Schedule\InterviewQuestion\InterviewQuestionRepository")
 */
class InterviewQuestion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    public function __construct(UuidInterface $id, string $question)
    {
        $this->id = $id->toString();
        $this->question = $question;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function updateInterviewQuestion(string $question): void
    {
        $this->question = $question;
    }
}
