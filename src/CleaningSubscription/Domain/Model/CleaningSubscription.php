<?php

declare(strict_types=1);

namespace App\CleaningSubscription\Domain\Model;

use App\CleaningSchedule\Domain\Model\CleaningSchedule;
use App\CleaningService\Domain\Model\CleaningService;
use App\CleaningSubscription\Domain\ValueObject\CleaningSubscriptionId;
use App\Location\Domain\Model\Location;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cleaning_subscription")
 */
class CleaningSubscription
{
    /**
     * @ORM\Id
     * @ORM\Column(type="cleaning_subscription_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?CleaningSubscriptionId $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Location\Domain\Model\Location", inversedBy="subscriptions")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    private Location $location;

    /**
     * @ORM\ManyToOne(targetEntity="\App\CleaningService\Domain\Model\CleaningService", inversedBy="subscriptions")
     * @ORM\JoinColumn(name="cleaning_service_id", referencedColumnName="id")
     */
    private CleaningService $cleaningService;

    /**
     * @var Collection|CleaningSchedule[]
     * @ORM\OneToMany(targetEntity="\App\CleaningSchedule\Domain\Model\CleaningSchedule", mappedBy="subscription")
     */
    private Collection $cleaningSchedule;

    public function __construct(Location $location, CleaningService $cleaningService)
    {
        $this->location = $location;
        $this->cleaningService = $cleaningService;
    }

    public function getId(): ?CleaningSubscriptionId
    {
        return $this->id;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getCleaningService(): CleaningService
    {
        return $this->cleaningService;
    }

    /**
     * @return Collection|CleaningSchedule[]
     */
    public function getCleaningSchedule(): Collection
    {
        return $this->cleaningSchedule;
    }
}
