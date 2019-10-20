<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\PassedDateException;

final class DateRangeInFuture
{
    private $startAt;
    private $endAt;

    public function __construct(\DateTimeInterface $startAt, \DateTimeInterface $endAt)
    {
        if ($startAt > $endAt) {
            throw new InvalidDateRangeException(sprintf('start At %s cannot be higher than end At %s', $startAt->format('Y-m-d'), $endAt->format('Y-m-d')));
        }

        if ($startAt < (new \DateTime())) {
            throw new PassedDateException(sprintf('The date %s cannot be in the past', $startAt->format('Y-m-d')));
        }

        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function getStartAt(): \DateTimeInterface
    {
        return $this->startAt;
    }

    public function getEndAt(): \DateTimeInterface
    {
        return $this->endAt;
    }

    public function getDuration(): \DateInterval
    {
        return $this->endAt->diff($this->startAt);
    }
}
