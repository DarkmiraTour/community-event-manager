<?php

declare(strict_types=1);

namespace App\Repository\Schedule;

use App\Entity\Event;
use App\Entity\Schedule;

final class ScheduleRepositoryManager
{
    private $repository;

    public function __construct(ScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Counts slot types for a list of schedules,
     * and returns an array indexed by scheludes ids.
     *
     * @param Event      $event
     * @param Schedule[] $schedules
     *
     * @return int[][] Array like:
     *                 [
     *                 1 => ['Talk' => 3, 'Workshop' => 2],
     *                 2 => ['Talk' => 4, 'Workshop' => 1, 'Other' => 1],
     *                 ]
     */
    public function countSlotTypes(Event $event, array $schedules = null): array
    {
        if (null === $schedules) {
            $schedules = $this->repository->findScheduleAndSlots($event);
        }

        $slotsTypes = [];

        foreach ($schedules as $schedule) {
            $slotsTypes[$schedule->getId()] = $this->countSlotTypesForSchedule($schedule);
        }

        return $slotsTypes;
    }

    /**
     * Counts slot types for a schedule day.
     *
     * @param Schedule $schedule
     *
     * @return int[] Array like: ['Talk' => 3, 'Workshop' => 2]
     */
    public function countSlotTypesForSchedule(Schedule $schedule): array
    {
        $slotsTypes = [];

        foreach ($schedule->getSpaces() as $space) {
            foreach ($space->getSlots() as $slot) {
                $description = $slot->getType()->getDescription();

                if (!isset($slotsTypes[$description])) {
                    $slotsTypes[$description] = 0;
                }

                $slotsTypes[$description]++;
            }
        }

        return $slotsTypes;
    }
}
