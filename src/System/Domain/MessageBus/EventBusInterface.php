<?php

declare(strict_types=1);

namespace App\System\Domain\MessageBus;

interface EventBusInterface
{
    public function dispatch($event): void;
}
