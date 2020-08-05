<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Service;

use App\NationalHoliday\Domain\Service\Exception\CountryNotSupportedException;
use App\NationalHoliday\Domain\Service\Generator\DutchNationalHolidayNationalHolidayGenerator;

class NationalHolidayGeneratorFactory
{
    /**
     * @var NationalHolidayGeneratorInterface[]
     */
    private array $nationalHolidayGenerators = [];

    public function __construct(DutchNationalHolidayNationalHolidayGenerator $dutchNationalHolidayGenerator)
    {
        $this->nationalHolidayGenerators[] = $dutchNationalHolidayGenerator;
    }

    /**
     * @return NationalHolidayGeneratorInterface
     * @throws CountryNotSupportedException
     */
    public function get(string $country): NationalHolidayGeneratorInterface
    {
        foreach ($this->nationalHolidayGenerators as $nationalHolidayGenerator) {
            if ($nationalHolidayGenerator->supports($country)) {
                return $nationalHolidayGenerator;
            }
        }

        throw new CountryNotSupportedException(
            sprintf('Country %s is currently not supported.', $country)
        );
    }
}
