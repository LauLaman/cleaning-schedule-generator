<?php

declare(strict_types=1);

namespace App\System\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Address
{
    /**
     * @ORM\Column(type="string")
     */
    private string $street;

    /**
     * @ORM\Column(type="integer")
     */
    private int $houseNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $houseNumberAddition;

    /**
     * @ORM\Column(type="string")
     */
    private string $postalCode;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $country;

    public function __construct(
        string $street,
        int $houseNumber,
        string $postalCode,
        string $city,
        string $country,
        ?string $houseNumberAddition = null
    ) {
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->houseNumberAddition = $houseNumberAddition;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNumber(): int
    {
        return $this->houseNumber;
    }

    public function getHouseNumberAddition(): ?string
    {
        return $this->houseNumberAddition;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
