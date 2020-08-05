<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\CommandHandler;

use App\NationalHoliday\Domain\Command\CreateHolidayCommand;
use App\NationalHoliday\Domain\Command\GenerateForYearCommand;
use App\NationalHoliday\Domain\Event\HolidaysGeneratedEvent;
use App\NationalHoliday\Domain\Service\NationalHolidayGeneratorFactory;
use App\System\Domain\MessageBus\CommandBusHandler;
use App\System\Domain\MessageBus\CommandBusInterface;
use App\System\Domain\MessageBus\EventBusInterface;

class GenerateForYearCommandHandler implements CommandBusHandler
{
    private CommandBusInterface $commandBus;
    private EventBusInterface $eventBus;
    private NationalHolidayGeneratorFactory $nationalHolidayGeneratorFactory;

    public function __construct(
        CommandBusInterface $commandBus,
        EventBusInterface $eventBus,
        NationalHolidayGeneratorFactory $nationalHolidayGeneratorFactory
    ) {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->nationalHolidayGeneratorFactory = $nationalHolidayGeneratorFactory;
    }

    public function __invoke(GenerateForYearCommand $command): void
    {
        $generator = $this->nationalHolidayGeneratorFactory->get($command->getCountry());

        foreach ($generator->getHolidays($command->getYear()) as $holiday) {
            $this->commandBus->dispatch(new CreateHolidayCommand(
                $holiday->getDate(),
                $holiday->getName(),
                $holiday->isDayOff(),
                $holiday->getCountry()
            ));
        }

        $this->eventBus->dispatch(new HolidaysGeneratedEvent($command->getYear(), $command->getCountry()));
    }
}
