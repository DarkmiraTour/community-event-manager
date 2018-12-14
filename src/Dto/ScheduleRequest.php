<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Schedule;
use Symfony\Component\Validator\Constraints as Assert;

final class ScheduleRequest
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

    public static function createFromEntity(Schedule $schedule): ScheduleRequest
    {
        return new ScheduleRequest(
            $schedule->getDay()
        );
    }

    public function updateSchedule(Schedule $schedule): void
    {
        $schedule->setDay($this->day);
    }
}
