<?php

declare(strict_types=1);

namespace App\Sponsorship;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SpecialBenefit
{
    private $id;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $label;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    private $price;
    /**
     * @Assert\NotBlank()
     */
    private $description;

    public function __construct(UuidInterface $id, string $label, float $price, string $description)
    {
        $this->id = $id->toString();
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function updateSpecialBenefit(string $label, float $price, string $description): void
    {
        $this->label = $label;
        $this->price = $price;
        $this->description = $description;
    }
}
