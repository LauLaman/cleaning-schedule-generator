<?php

declare(strict_types=1);

namespace App\System\Infrastructure\MessageBus;

use App\System\Domain\MessageBus\EventBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements EventBusInterface
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch($command): void
    {
        $this->eventBus->dispatch($command);
    }
}

