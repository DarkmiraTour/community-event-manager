<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\space;
use Symfony\Component\Validator\Constraints as Assert;

final class SpaceRequest
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $schedule;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @var bool
     * @Assert\NotBlank()
     */
    public $visible;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $schedule = null, string $type = null, bool $visible = true, string $name = null)
    {
        $this->schedule = $schedule;
        $this->type = $type;
        $this->visible = $visible;
        $this->name = $name;
    }

    public static function createFromEntity(Space $space): SpaceRequest
    {
        return new SpaceRequest(
            $space->getSchedule(),
            $space->getType(),
            $space->getVisible(),
            $space->getName()
        );
    }

    public function updateSpace(Space $space): void
    {
        $space->setSchedule($this->schedule);
        $space->setType($this->type);
        $space->setVisible($this->visible);
        $space->setName($this->name);
    }
}
