<?php

declare(strict_types=1);

namespace App\System\Infrastructure\MessageBus;

use App\System\Domain\MessageBus\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch($command): void
    {
        $this->commandBus->dispatch($command);
    }
}

