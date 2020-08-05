<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Event;

use App\NationalHoliday\Domain\ValueObject\NationalHolidayId;

class NationalHolidayCreatedEvent
{
    private NationalHolidayId $id;

    public function __construct(NationalHolidayId $id)
    {
        $this->id = $id;
    }

    public function getId(): NationalHolidayId
    {
        return $this->id;
    }
}
