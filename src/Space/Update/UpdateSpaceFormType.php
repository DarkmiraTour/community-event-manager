<?php

declare(strict_types=1);

namespace App\Space\Update;

use App\Space\Create\CreateSpaceFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateSpaceFormType extends CreateSpaceFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateSpaceRequest::class,
        ]);
    }
}
