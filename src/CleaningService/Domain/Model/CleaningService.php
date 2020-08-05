<?php

declare(strict_types=1);

namespace App\CleaningService\Domain\Model;

use App\CleaningService\Domain\ValueObject\CleaningServiceId;
use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cleaning_service")
 */
class CleaningService
{
    /**
     * @ORM\Id
     * @ORM\Column(type="cleaning_service_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?CleaningServiceId $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $timeInMinutes;

    /**
     * @var Collection|CleaningSubscription[]
     * @ORM\OneToMany(targetEntity="\App\CleaningSubscription\Domain\Model\CleaningSubscription", mappedBy="cleaningService")
     */
    private Collection $subscriptions;

    public function __construct(string $name, int $timeInMinutes)
    {
        $this->name = $name;
        $this->timeInMinutes = $timeInMinutes;
    }
}
