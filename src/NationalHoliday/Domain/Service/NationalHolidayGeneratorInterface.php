<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Service;

use App\NationalHoliday\Domain\ValueObject\GeneratedNationalHoliday;
use Generator;

interface NationalHolidayGeneratorInterface
{
    public function supports(string $country): bool;

    /**
     * @return GeneratedNationalHoliday[]
     */
    public function getHolidays(int $year): iterable;
}
