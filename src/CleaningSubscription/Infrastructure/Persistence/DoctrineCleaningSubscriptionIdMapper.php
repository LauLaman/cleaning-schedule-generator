<?php

declare(strict_types=1);

namespace App\CleaningSubscription\Infrastructure\Persistence;

use App\CleaningSubscription\Domain\ValueObject\CleaningSubscriptionId;
use Noahlvb\ValueObjectBundle\Persistence\Type\ValueObjectType;

class DoctrineCleaningSubscriptionIdMapper extends ValueObjectType
{
    public function getClassName(): string
    {
        return CleaningSubscriptionId::class;
    }

    public function getName(): string
    {
        return 'Cleaning_Subscription_Id';
    }
}
