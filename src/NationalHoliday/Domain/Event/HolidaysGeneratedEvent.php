<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Event;

class HolidaysGeneratedEvent
{
    private int $year;
    private string $country;

    public function __construct(int $year, string $country)
    {
        $this->year = $year;
        $this->country = $country;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
