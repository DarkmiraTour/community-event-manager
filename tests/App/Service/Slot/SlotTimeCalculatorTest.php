<?php

namespace App\Tests\Service\Slot;

use PHPUnit\Framework\TestCase;
use App\Service\Slot\SlotTimeCalculator;

class SlotTimeCalculatorTest extends TestCase
{
    public function testCalculatesDuration()
    {
        $calculator = new SlotTimeCalculator();

        $format = 'Y-m-d H:i:s';

        $duration = $calculator->calculatesDuration(
            \DateTime::createFromFormat($format, '2019-07-30 12:00:00'),
            \DateTime::createFromFormat($format, '2019-07-30 14:00:00')
        );

        $this->assertEquals(120, $duration);

        $duration = $calculator->calculatesDuration(
            \DateTime::createFromFormat($format, '2019-07-30 15:00:00'),
            \DateTime::createFromFormat($format, '2019-07-30 16:30:00')
        );

        $this->assertEquals(90, $duration);
    }
}
