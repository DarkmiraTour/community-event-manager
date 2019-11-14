<?php

declare(strict_types=1);

namespace App\Schedule\Create;

use App\Schedule\Schedule;
use Symfony\Component\Validator\Constraints as Assert;

class CreateScheduleRequest
{
    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    public $day;

    public function __construct(string $day = null)
    {
        $this->day = $day;
    }

    public static function createFromEntity(Schedule $schedule): self
    {
        return new self($schedule->getDay());
    }
}
