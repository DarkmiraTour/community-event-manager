<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Dto\SlotRequest;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class EventCanStartSlotValidator extends ConstraintValidator
{
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

        if ($value <= $slotRequest->start) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
