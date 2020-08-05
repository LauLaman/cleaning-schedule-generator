<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Service\Generator;

use LogicException;

abstract class AbstractNationalHolidayGenerator
{
    protected static string $countryCode = '';
    protected static string $timezone = '';

    public function __construct()
    {
        if (static::$countryCode === '' || static::$timezone === '') {
            throw new LogicException('Please implement both \'$countryCode\' and \'$timezone\' on the implemented class');
        }
    }

    final public function supports(string $country): bool
    {
        return $country === static::$countryCode;
    }
}
