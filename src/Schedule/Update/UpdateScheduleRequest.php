<?php

declare(strict_types=1);

namespace App\Schedule\Update;

use App\Schedule\Create\CreateScheduleRequest;
use App\Schedule\Schedule;

final class UpdateScheduleRequest extends CreateScheduleRequest
{
    public function updateSchedule(Schedule $schedule): Schedule
    {
        return  $schedule->setDay($this->day);
    }
}
