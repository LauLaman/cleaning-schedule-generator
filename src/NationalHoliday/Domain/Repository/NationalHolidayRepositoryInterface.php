<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Repository;

use App\NationalHoliday\Domain\Model\NationalHoliday;
use App\NationalHoliday\Domain\ValueObject\NationalHolidayId;
use App\System\Domain\Repository\Exception\NoResultException;
use DatePeriod;

interface NationalHolidayRepositoryInterface
{
    /**
     * @throws NoResultException
     */
    public function get(NationalHolidayId $id): NationalHoliday;

    /**
     * @return NationalHoliday[]
     */
    public function getForDateRange(DatePeriod $datePeriod, string $country);

    public function persist(NationalHoliday $entity): void;

    public function flush(): void;
}
