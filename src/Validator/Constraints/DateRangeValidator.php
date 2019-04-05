<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Exceptions\Validator\Constraints\NoFormInValidatorException;
use App\Exceptions\Validator\Constraints\UnavailableDateRangePropertiesException;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class DateRangeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof DateRange) {
            throw new UnexpectedTypeException($constraint, DateRange::class);
        }

        $form = $this->context->getRoot();

        if (!$form instanceof Form) {
            throw new NoFormInValidatorException('Validator need to retrieve a Symfony form to work');
        }

        $dtoRequest = $form->getViewData();
        if (!property_exists($dtoRequest, 'startAt') && !property_exists($dtoRequest, 'endAt')) {
            throw new UnavailableDateRangePropertiesException('Validator DateRange need two public parameters to work, DateTimeInterface startAt and DateTimeInterface endAt');
        }

        if ($dtoRequest->startAt > $dtoRequest->endAt) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ startDate }}', $dtoRequest->startAt->format('M d Y'))
                ->setParameter('{{ endDate }}', $dtoRequest->endAt->format('M d Y'))
                ->addViolation();
        }
    }
}
