<?php

declare(strict_types=1);

namespace App\CleaningService\Infrastructure\Persistence;

use App\CleaningService\Domain\ValueObject\CleaningServiceId;
use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class DoctrineCleaningServiceIdMapper extends ValueObjectType
{
    public function getClassName(): string
    {
        return CleaningServiceId::class;
    }

    public function getName(): string
    {
        return 'cleaning_service_id';
    }
}
