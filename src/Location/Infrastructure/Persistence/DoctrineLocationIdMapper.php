<?php

declare(strict_types=1);

namespace App\Location\Infrastructure\Persistence;

use App\Location\Domain\ValueObject\LocationId;
use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class DoctrineLocationIdMapper extends ValueObjectType
{
    public function getClassName(): string
    {
        return LocationId::class;
    }

    public function getName(): string
    {
        return 'location_id';
    }
}
