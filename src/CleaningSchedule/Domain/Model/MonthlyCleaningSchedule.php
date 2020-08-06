<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\Model;

use App\CleaningSchedule\Domain\ValueObject\MonthlySchedule;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="cleaning_schedule_monthly")
 */
class MonthlyCleaningSchedule extends CleaningSchedule
{
    /**
     * @ORM\Column(type="enum_monthly_schedule")
     */
    private MonthlySchedule $monthlySchedule;

    public function __construct(
        CleaningSubscription $subscription,
        MonthlySchedule $monthlySchedule
    ) {
        parent::__construct($subscription);
        $this->monthlySchedule = $monthlySchedule;
    }

    public function shouldPerform(DateTimeImmutable $date): bool
    {
        if ($this->monthlySchedule->isFirstDayOfTheMonth()) {
            return $date->modify('first day of this month')->format('y-m-d') === $date->format('y-m-d');
        }

        if ($this->monthlySchedule->isLastWorkingDayOfTheMonth()) {
            return $date->modify('last day of this month')->format('y-m-d') === $date->format('y-m-d');
        }

        return false;
    }
}
