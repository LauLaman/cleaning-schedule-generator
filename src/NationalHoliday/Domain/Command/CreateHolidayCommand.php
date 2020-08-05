<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Command;

use DateTimeImmutable;

class CreateHolidayCommand
{
    private DateTimeImmutable $date;
    private string $name;
    private bool $dayOff;
    private string $country;

    public function __construct(DateTimeImmutable $date, string $name, bool $dayOff, string $country)
    {
        $this->date = $date;
        $this->name = $name;
        $this->dayOff = $dayOff;
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
