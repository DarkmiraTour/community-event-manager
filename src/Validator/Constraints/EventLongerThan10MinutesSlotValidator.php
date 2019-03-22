<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Dto\SlotRequest;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class EventLongerThan10MinutesSlotValidator extends ConstraintValidator
{
    private const CHECK_HOUR = 0;
    private const CHECK_MINUTES = 10;

    public function validate($value, Constraint $constraint): void
    {
        if (!$value) {
            return;
        }

        $form = $this->context->getRoot();

        if (!$form instanceof Form) {
            return;
        }

        /** @var SlotRequest $slotRequest */
        $slotRequest = $form->getData();

        $diff = $value->diff($slotRequest->start);
        if (self::CHECK_MINUTES > $diff->i && self::CHECK_HOUR === $diff->h) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
