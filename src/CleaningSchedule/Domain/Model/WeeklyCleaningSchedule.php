<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\Model;

use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="cleaning_schedule_weekly")
 */
class WeeklyCleaningSchedule extends CleaningSchedule
{
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $monday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $tuesday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $wednesday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $thursday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $friday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $saturday;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $sunday;

    public function __construct(
        CleaningSubscription $subscription,
        bool $monday,
        bool $tuesday,
        bool $wednesday,
        bool $thursday,
        bool $friday,
        bool $saturday,
        bool $sunday
    ) {
        parent::__construct($subscription);

        $this->monday = $monday;
        $this->tuesday = $tuesday;
        $this->wednesday = $wednesday;
        $this->thursday = $thursday;
        $this->friday = $friday;
        $this->saturday = $saturday;
        $this->sunday = $sunday;
    }

    public function onMonday(): bool
    {
        return $this->monday;
    }

    public function onTuesday(): bool
    {
        return $this->tuesday;
    }

    public function onWednesday(): bool
    {
        return $this->wednesday;
    }

    public function onThursday(): bool
    {
        return $this->thursday;
    }

    public function onFriday(): bool
    {
        return $this->friday;
    }

    public function onSaturday(): bool
    {
        return $this->saturday;
    }

    public function onSunday(): bool
    {
        return $this->sunday;
    }


}
