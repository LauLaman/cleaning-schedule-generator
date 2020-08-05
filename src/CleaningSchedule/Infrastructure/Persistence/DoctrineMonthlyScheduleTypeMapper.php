<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Infrastructure\Persistence;

use App\CleaningSchedule\Domain\ValueObject\MonthlySchedule;
use App\System\Infrastructure\Persistence\AbstractDoctrineEnumMapper;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineMonthlyScheduleTypeMapper extends AbstractDoctrineEnumMapper
{
    protected function getEnumClass()
    {
        return MonthlySchedule::class;
    }

    public function getName(): string
    {
        return 'enum_monthly_schedule';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}
{

}
