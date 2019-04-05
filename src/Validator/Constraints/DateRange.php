<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class DateRange extends Constraint
{
    public $message = 'Start date "{{ startDate }}" cannot be higher than end date "{{ endDate }}".';
}
