<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\space;
use Symfony\Component\Validator\Constraints as Assert;

final class SpaceRequest
{
    /**
     * @var bool
     * @Assert\NotBlank()
     */
    public $visible;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(bool $visible = true, string $type = null, string $name = null)
    {
        $this->visible = $visible;
        $this->type = $type;
        $this->name = $name;
    }

    public static function createForm(Space $space): SpaceRequest
    {
        return new SpaceRequest(
            $space->getVisible(),
            $space->getType(),
            $space->getName()
        );
    }

    public function updateSpace(Space $space): void
    {
        $space->setVisible($this->visible);
        $space->setType($this->type);
        $space->setName($this->name);
    }
}