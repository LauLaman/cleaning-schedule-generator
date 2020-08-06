<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\Model;

use App\CleaningSchedule\Domain\ValueObject\CleaningScheduleId;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cleaning_schedule")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="enum_cleaning_schedule_type")
 * @ORM\DiscriminatorMap({
 *     "WEEKLY" = "\App\CleaningSchedule\Domain\Model\WeeklyCleaningSchedule",
 *     "MONTHLY" = "\App\CleaningSchedule\Domain\Model\MonthlyCleaningSchedule",
 * })
 */
abstract class CleaningSchedule
{
    /**
     * @ORM\Id
     * @ORM\Column(type="cleaning_schedule_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?CleaningScheduleId $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\CleaningSubscription\Domain\Model\CleaningSubscription", inversedBy="cleaningSchedule")
     * @ORM\JoinColumn(name="cleaning_subscription_id", referencedColumnName="id")
     */
    private CleaningSubscription $subscription;

    /**
     * @ORM\ManyToOne(targetEntity="\App\CleaningSchedule\Domain\Model\CleaningSchedule", inversedBy="childSchedule")
     * @ORM\JoinColumn(name="parent_cleaning_schedule_id", referencedColumnName="id", nullable=true)
     */
    protected ?CleaningSchedule $parentSchedule;

    /**
     * @var Collection|CleaningSchedule[]
     * @ORM\OneToMany(targetEntity="\App\CleaningSchedule\Domain\Model\CleaningSchedule", mappedBy="parentSchedule")
     */
    private Collection $childSchedule;

    public function __construct(CleaningSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function setParentSchedule(CleaningSchedule $cleaningSchedule)
    {
        $this->parentSchedule = $cleaningSchedule;
    }

    public function getId(): ?CleaningScheduleId
    {
        return $this->id;
    }

    public function getSubscription(): CleaningSubscription
    {
        return $this->subscription;
    }

    public function hasParentSchedule(): bool
    {
        return null !== $this->parentSchedule;
    }

    public function shouldPerformOnDate(DateTimeImmutable $date): bool
    {
        if (!$this->shouldPerform($date)) {
            return false;
        }

        if ($this->hasParentSchedule()) {
            return $this->parentSchedule->shouldPerformOnDate($date);
        }

        return true;
    }

    abstract protected function shouldPerform(DateTimeImmutable $date): bool;
}
