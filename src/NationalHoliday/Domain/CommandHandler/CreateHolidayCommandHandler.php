<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\CommandHandler;

use App\NationalHoliday\Domain\Command\CreateHolidayCommand;
use App\NationalHoliday\Domain\Event\NationalHolidayCreatedEvent;
use App\NationalHoliday\Domain\Model\NationalHoliday;
use App\NationalHoliday\Domain\Repository\NationalHolidayRepositoryInterface;
use App\System\Domain\MessageBus\CommandBusHandler;
use App\System\Domain\MessageBus\EventBusInterface;

class CreateHolidayCommandHandler implements CommandBusHandler
{
    private NationalHolidayRepositoryInterface $nationalHolidayRepository;
    private EventBusInterface $eventBus;

    public function __construct(
        NationalHolidayRepositoryInterface $nationalHolidayRepository,
        EventBusInterface $eventBus
    ) {
        $this->nationalHolidayRepository = $nationalHolidayRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateHolidayCommand $command): void
    {
        $nationalHoliday = new NationalHoliday(
            $command->getDate(),
            $command->getName(),
            $command->isDayOff(),
            $command->getCountry(),
        );

        $this->nationalHolidayRepository->persist($nationalHoliday);
        $this->nationalHolidayRepository->flush();

        $this->eventBus->dispatch(new NationalHolidayCreatedEvent($nationalHoliday->getId()));
    }
}
