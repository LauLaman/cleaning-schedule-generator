<?php

declare(strict_types=1);

namespace App\System\Domain\MessageBus;

interface CommandBusInterface
{
    public function dispatch($command): void;
}
