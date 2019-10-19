<?php

declare(strict_types=1);

namespace App\Talk\Create;

use App\Speaker\Speaker;
use App\Talk\Talk;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTalkRequest
{
    /**
     * @var string|null
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    public $description;

    /** @var Speaker|null */
    public $speaker;

    public static function createFromEntity(Talk $talk): self
    {
        $request = new static();
        $request->title = $talk->getTitle();
        $request->description = $talk->getDescription();
        $request->speaker = $talk->getSpeaker();

        return $request;
    }
}
