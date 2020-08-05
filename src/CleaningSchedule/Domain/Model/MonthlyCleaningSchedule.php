<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\Model;

use App\CleaningSchedule\Domain\ValueObject\MonthlySchedule;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
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
}
