<?php

declare(strict_types=1);

namespace App\Timetable\Domain\Model;

use App\CleaningSchedule\Domain\Model\CleaningSchedule;
use App\CleaningService\Domain\ValueObject\CleaningServiceId;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use DateTimeInterface;

class CleaningTask
{
    private CleaningServiceId $cleaningServiceId;
    private string $name;
    private int $timeInMinutes;

    /**
     * @var iterable|CleaningSchedule[]
     */
    private iterable $schedules;

    public function __construct(CleaningSubscription $subscription)
    {
        $this->cleaningServiceId = $subscription->getCleaningService()->getId();
        $this->name = $subscription->getCleaningService()->getName();
        $this->timeInMinutes = $subscription->getCleaningService()->getTimeInMinutes();
        $this->schedules = $subscription->getCleaningSchedule();
    }

    public function getCleaningServiceId(): ?CleaningServiceId
    {
        return $this->cleaningServiceId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimeInMinutes(): int
    {
        return $this->timeInMinutes;
    }

    public function shouldPerformOnDate(DateTimeInterface $date): bool
    {
        /** @var CleaningSchedule $schedule */
        foreach ($this->schedules as $schedule) {
            if ($schedule->shouldPerformOnDate($date)) {
                return true;
            }
        }
        return false;
    }
}
