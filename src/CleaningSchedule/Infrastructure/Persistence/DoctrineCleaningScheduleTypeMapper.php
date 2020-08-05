<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Infrastructure\Persistence;

use App\CleaningSchedule\Domain\ValueObject\CleaningScheduleType;
use App\System\Infrastructure\Persistence\AbstractDoctrineEnumMapper;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineCleaningScheduleTypeMapper extends AbstractDoctrineEnumMapper
{
    protected function getEnumClass()
    {
        return CleaningScheduleType::class;
    }

    public function getName(): string
    {
        return 'enum_cleaning_schedule_type';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}
