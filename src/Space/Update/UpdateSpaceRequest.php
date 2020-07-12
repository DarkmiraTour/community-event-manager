<?php

declare(strict_types=1);

namespace App\Space\Update;

use App\Space\Create\CreateSpaceRequest;
use App\Space\Space;

final class UpdateSpaceRequest extends CreateSpaceRequest
{
    public function updateSpace(Space $space): Space
    {
        return $space->setSchedule($this->schedule)
                    ->setType($this->type)
                    ->setVisible($this->visible)
                    ->setName($this->name);
    }
}
