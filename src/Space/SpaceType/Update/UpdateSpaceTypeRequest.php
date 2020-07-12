<?php

declare(strict_types=1);

namespace App\Space\SpaceType\Update;

use App\Space\SpaceType\Create\CreateSpaceTypeRequest;
use App\Space\SpaceType\SpaceType;

final class UpdateSpaceTypeRequest extends CreateSpaceTypeRequest
{
    public function updateEntity(SpaceType $spaceType): SpaceType
    {
        $spaceType
            ->setName($this->name)
            ->setDescription($this->description);

        return $spaceType;
    }
}
