<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class DateInFuture extends Constraint
{
    public $message = 'The date "{{ date }}" cannot be set in the past.';
}
