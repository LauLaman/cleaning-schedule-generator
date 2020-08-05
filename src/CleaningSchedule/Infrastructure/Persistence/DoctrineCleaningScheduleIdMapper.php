<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Infrastructure\Persistence;

use App\CleaningSchedule\Domain\ValueObject\CleaningScheduleId;
use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class DoctrineCleaningScheduleIdMapper extends ValueObjectType
{
    public function getClassName(): string
    {
        return CleaningScheduleId::class;
    }

    public function getName(): string
    {
        return 'cleaning_schedule_id';
    }
}
