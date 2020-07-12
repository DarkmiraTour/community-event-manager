<?php

declare(strict_types=1);

namespace App\Space\SpaceType\Update;

use App\Space\SpaceType\Create\CreateSpaceTypeFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UpdateSpaceTypeFormType extends CreateSpaceTypeFormType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateSpaceTypeRequest::class,
        ]);
    }
}
