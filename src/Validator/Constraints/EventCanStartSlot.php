<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class EventCanStartSlot extends Constraint
{
    public $message = 'The event cannot start after it ends';
}
