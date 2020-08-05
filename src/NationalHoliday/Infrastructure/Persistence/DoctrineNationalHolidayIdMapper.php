<?php

declare(strict_types=1);

namespace App\NationalHoliday\Infrastructure\Persistence;

use App\NationalHoliday\Domain\ValueObject\NationalHolidayId;
use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class DoctrineNationalHolidayIdMapper extends ValueObjectType
{
    public function getClassName(): string
    {
        return NationalHolidayId::class;
    }

    public function getName(): string
    {
        return 'national_holiday_id';
    }
}
