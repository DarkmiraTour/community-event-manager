<?php

declare(strict_types=1);

namespace App\Service\Schedule;

use App\Entity\Schedule;
use App\Entity\Slot;
use App\Entity\Space;

final class CreateDailySchedule
{
    public function mountTimetable($schedules): array
    {
        $timetable = [];
        /** @var Schedule $day */
        foreach ($schedules as $day) {
            $timetableDay = $day->getDay()->format('dmY');
            $timetable[$timetableDay] = [];

            $spaces = $this->mountActivitiesInArray($day);

            /** @var Space $space */
            foreach ($day->getSpaces() as $space) {
                /** @var Slot $slot */
                foreach ($space->getSlots() as $slot) {
                    $hour = $this->combineSlotStartEnd($slot);

                    $timetable[$timetableDay][$hour] = $timetable[$timetableDay][$hour] ?? $spaces;

                    $timetable[$timetableDay][$hour][$space->getName()] = $slot;
                }
            }

            ksort($timetable[$timetableDay]);
        }

        ksort($timetable);

        return $timetable;
    }

    private function combineSlotStartEnd(Slot $slot): string
    {
        $slotStart = $slot->getStart()->format('H:i');
        $slotEnd = $slot->getEnd()->format('H:i');

        return "$slotStart - $slotEnd";
    }

    private function mountActivitiesInArray(Schedule $schedule): array
    {
        $spaces = [];

        /** @var Space $space */
        foreach ($schedule->getSpaces() as $space) {
            $spaces[$space->getName()] = '---';
        }

        return $spaces;
    }
}
