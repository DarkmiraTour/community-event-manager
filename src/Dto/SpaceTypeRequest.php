<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\SpaceType;
use Symfony\Component\Validator\Constraints as Assert;

final class SpaceTypeRequest
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $description;

    public static function createFromEntity(SpaceType $spaceType): SpaceTypeRequest
    {
        $spaceTypeRequest = new self();

        $spaceTypeRequest->name = $spaceType->getName();
        $spaceTypeRequest->description = $spaceType->getDescription();

        return $spaceTypeRequest;
    }

    public function updateEntity(SpaceType $spaceType): SpaceType
    {
        $spaceType
            ->setName($this->name)
            ->setDescription($this->description);

        return $spaceType;
    }
}
