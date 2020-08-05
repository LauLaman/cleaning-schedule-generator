<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\ValueObject;

use DateTimeImmutable;

class GeneratedNationalHoliday
{
    private DateTimeImmutable $date;
    private string $name;
    private bool $dayOff;
    private string $country;

    public function __construct(DateTimeImmutable $date, string $name, bool $dayOf, string $country)
    {
        $this->date = $date;
        $this->name = $name;
        $this->dayOff = $dayOf;
        $this->country = $country;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDayOff(): bool
    {
        return $this->dayOff;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
