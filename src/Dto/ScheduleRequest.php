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


    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $place;


    public function __construct(string $day = null, string $place = null)
    {
        $this->day = $day;
        $this->place = $place;
    }

    public static function createForm(Schedule $schedule): ScheduleRequest
    {
        return new ScheduleRequest(
            $schedule->getDay()
        );
    }

    public function updateSchedule(Schedule $schedule): void
    {
        $schedule->setDay($this->day);
        $schedule->setPlace($this->place);
    }
}