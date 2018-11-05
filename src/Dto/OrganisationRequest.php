<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Organisation;
use Symfony\Component\Validator\Constraints as Assert;

final class OrganisationRequest
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public $website;

    public $address;

    public $comment;

    /**
     * OrganisationRequest constructor.
     * @param $name
     * @param $website
     * @param $address
     * @param $comment
     */
    public function __construct(string $name = null, string $website = null, string $address = null, string $comment = null)
    {
        $this->name = $name;
        $this->website = $website;
        $this->address = $address;
        $this->comment = $comment;
    }


}
