<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Talk;
use Symfony\Component\Validator\Constraints as Assert;

final class TalkRequest
{
    /**
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @Assert\NotBlank()
     */
    public $description;

    public $speaker;

    public static function createFromEntity(Talk $talk): TalkRequest
    {
        $request = new self();

        $request->title = $talk->getTitle();
        $request->description = $talk->getDescription();
        $request->speaker = $talk->getSpeaker();

        return $request;
    }

    public function updateEntity(Talk $talk): Talk
    {
        $talk->setTitle($this->title)
            ->setDescription($this->description)
            ->setSpeaker($this->speaker);

        return $talk;
    }
}
