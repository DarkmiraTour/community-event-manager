<?php

declare(strict_types=1);

namespace App\Space\Create;

use App\Space\Space;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSpaceRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $schedule;

    /**
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @Assert\NotBlank()
     */
    public $visible;

    /**
     * @Assert\NotBlank()
     */
    public $name;

    public static function createFromEntity(Space $space): self
    {
        $request = new static();
        $request->schedule = $space->getSchedule();
        $request->type = $space->getType();
        $request->visible = $space->getVisible();
        $request->name = $space->getName();

        return $request;
    }
}
