<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class DateInFutureValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof DateInFuture) {
            throw new UnexpectedTypeException($constraint, DateInFuture::class);
        }

        if (null === $value || '' === $value || (!$value instanceof \DateTimeInterface)) {
            return;
        }

        if ($value < (new \DateTime('now'))) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ date }}', $value->format('M d Y'))
                ->addViolation();
        }
    }
}
