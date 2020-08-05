<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Model;

use App\NationalHoliday\Domain\ValueObject\NationalHolidayId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="national_holiday")
 */
class NationalHoliday
{
    /**
     * @ORM\Id
     * @ORM\Column(type="national_holiday_id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private NationalHolidayId $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $dayOff;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private string $country;

    public function __construct(DateTimeImmutable $date, string $name, bool $dayOff, string $country)
    {
        $this->date = $date;
        $this->name = $name;
        $this->dayOff = $dayOff;
        $this->country = $country;
    }

    public function getId(): NationalHolidayId
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDayOff(): bool
    {
        return $this->dayOff;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
