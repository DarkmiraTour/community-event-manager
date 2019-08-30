<?php

declare(strict_types=1);

namespace App\Talk\Update;

use App\Talk\Create\CreateTalkRequest;
use App\Talk\Talk;

/**
 * @method static UpdateTalkRequest createFromEntity(Talk $talk)
 */
final class UpdateTalkRequest extends CreateTalkRequest
{
    public function updateEntity(Talk $talk): Talk
    {
        return $talk->setTitle($this->title)
            ->setDescription($this->description)
            ->setSpeaker($this->speaker);
    }
}
