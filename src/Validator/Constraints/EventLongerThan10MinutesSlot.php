<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class EventLongerThan10MinutesSlot extends Constraint
{
    public $message = 'The event should be longer than 10 minutes';
}
