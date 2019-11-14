<?php

declare(strict_types=1);

namespace App\Schedule\Update;

use App\Schedule\Create\CreateScheduleFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdateScheduleFormType extends CreateScheduleFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateScheduleRequest::class,
        ]);
    }
}
