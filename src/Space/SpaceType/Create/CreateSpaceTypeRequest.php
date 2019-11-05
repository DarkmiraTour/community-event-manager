<?php

declare(strict_types=1);

namespace App\Space\SpaceType\Create;

use App\Space\SpaceType\SpaceType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSpaceTypeRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     */
    public $description;

    public static function createFromEntity(SpaceType $spaceType): CreateSpaceTypeRequest
    {
        $spaceTypeRequest = new self();

        $spaceTypeRequest->name = $spaceType->getName();
        $spaceTypeRequest->description = $spaceType->getDescription();

        return $spaceTypeRequest;
    }
}
