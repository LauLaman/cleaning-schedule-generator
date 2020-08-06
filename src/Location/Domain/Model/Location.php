<?php

declare(strict_types=1);

namespace App\Location\Domain\Model;

use App\CleaningSubscription\Domain\Model\CleaningSubscription;
use App\Location\Domain\ValueObject\LocationId;
use App\System\Domain\Model\Address;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(type="location_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?LocationId $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Embedded(class="\App\System\Domain\Model\Address")
     */
    private Address $address;

    /**
     * @var Collection|CleaningSubscription[]
     * @ORM\OneToMany(targetEntity="\App\CleaningSubscription\Domain\Model\CleaningSubscription", mappedBy="location")
     */
    private Collection $subscriptions;

    public function __construct(string $name, Address $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    public function getId(): ?LocationId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Collection|CleaningSubscription
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }
}
