<?php

declare(strict_types=1);

namespace App\Talk\Update;

use App\Talk\Create\CreateTalkFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdateTalkFormType extends CreateTalkFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateTalkRequest::class,
        ]);
    }
}
