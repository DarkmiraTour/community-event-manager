<?php

declare(strict_types=1);

namespace App\Service\Slot;

final class SlotTimeCalculator
{
    public function calculatesDuration(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        $diff = $end->diff($start);
        $duration = ($diff->h * 60) + $diff->i;

        return $duration;
    }
}
