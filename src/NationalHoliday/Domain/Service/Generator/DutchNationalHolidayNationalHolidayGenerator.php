<?php

declare(strict_types=1);

namespace App\NationalHoliday\Domain\Service\Generator;

use App\NationalHoliday\Domain\Service\NationalHolidayGeneratorInterface;
use App\NationalHoliday\Domain\ValueObject\GeneratedNationalHoliday;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;

class DutchNationalHolidayNationalHolidayGenerator extends AbstractNationalHolidayGenerator implements NationalHolidayGeneratorInterface
{
    protected static string $countryCode = 'NLD';
    protected static string $timezone = 'Europe/Amsterdam';

    /**
     * @return GeneratedNationalHoliday[]
     */
    public function getHolidays(int $year): array
    {
        $holidays = [];

        $holidays[] = $this->getNewYearsDay($year);
        $holidays = array_merge($holidays, $this->getEaster($year));
        $holidays[] = $this->getRoyalDays($year);
        $holidays[] = $this->getRemembranceDay($year);
        $holidays[] = $this->getLiberationDay($year);
        $holidays[] = $this->getSaintNicholasDay($year);
        $holidays = array_merge($holidays, $this->getChristmas($year));
        $holidays[] = $this->getNewYearsEve($year);

        return $holidays;
    }

    private function getNewYearsDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('first day of january %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Nieuwjaarsdag',
            true,
            self::$countryCode
        );
    }

    /**
     * @return GeneratedNationalHoliday[]
     */
    private function getEaster(int $year): array
    {
        $baseDate = new DateTime(sprintf('21-03-%s', $year), new DateTimeZone(static::$timezone));
        $days = easter_days(2020);
        $baseDate->add(new DateInterval(sprintf('P%sD', $days)));

        $easter = DateTimeImmutable::createFromMutable($baseDate);

        return [
            $this->getGoodFriday($easter),
            $this->getFirstEasterDay($easter),
            $this->getSecondEasterDay($easter),
            $this->getAscensionDay($easter),
            $this->getFirstPentecostDay($easter),
            $this->getSecondPentecostDay($easter),
        ];
    }

    private function getGoodFriday(DateTimeImmutable $easter): GeneratedNationalHoliday
    {
        $goodFriday = $easter->modify('last friday');

        return new GeneratedNationalHoliday(
            $goodFriday,
            'Goede vrijdag',
            true,
            self::$countryCode
        );
    }

    private function getFirstEasterDay(DateTimeImmutable $easter): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            $easter,
            'Eerste paasdag',
            true,
            self::$countryCode
        );
    }

    private function getSecondEasterDay(DateTimeImmutable $easter): GeneratedNationalHoliday
    {
        $easterMonday = $easter->modify('next monday');

        return new GeneratedNationalHoliday(
            $easterMonday,
            'Tweede paasdag',
            true,
            self::$countryCode
        );
    }

    private function getAscensionDay(DateTimeImmutable $easter)
    {
        $ascensionDay = $easter->modify('+39 days');

        return new GeneratedNationalHoliday(
            $ascensionDay,
            'Hemelvaart',
            true,
            self::$countryCode
        );
    }

    private function getFirstPentecostDay(DateTimeImmutable $easter)
    {
        $firstPentecostDay = $easter->modify('+49 days');

        return new GeneratedNationalHoliday(
            $firstPentecostDay,
            'Eerste Pinksterdag',
            true,
            self::$countryCode
        );
    }

    private function getSecondPentecostDay(DateTimeImmutable $easter)
    {
        $secondPentecostDay = $easter->modify('+50 days');

        return new GeneratedNationalHoliday(
            $secondPentecostDay,
            'Tweede Pinksterdag',
            true,
            self::$countryCode
        );
    }

    private function getRoyalDays(int $year): GeneratedNationalHoliday
    {
        if ($year < 2014) {
            $queensDay = new DateTime('00:00:00', new DateTimeZone(static::$timezone));
            $queensDay->modify(sprintf('30 april %s', $year));

            return new GeneratedNationalHoliday(
                DateTimeImmutable::createFromMutable($queensDay),
                'Koninginnedag',
                true,
                self::$countryCode
            );
        }

        if ($year > 2013) {
            $kingsDay = new DateTime('00:00:00', new DateTimeZone(static::$timezone));
            $kingsDay->modify(sprintf('27 april %s', $year));

            return new GeneratedNationalHoliday(
                DateTimeImmutable::createFromMutable($kingsDay),
                'Koningsdag',
                true,
                self::$countryCode
            );
        }
    }

    private function getRemembranceDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('4 may %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Dodenherdenking',
            false,
            self::$countryCode
        );
    }

    private function getLiberationDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('5 may %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Bevrijdingsdag',
            ($year % 5 != 0),
            self::$countryCode
        );
    }

    private function getSaintNicholasDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('5 december %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Sinterklaas',
            false,
            self::$countryCode
        );
    }

    /**
     * @return GeneratedNationalHoliday[]
     */
    private function getChristmas(int $year): array
    {
        return  [
            $this->getChristmasEve($year),
            $this->getFirstChristmasDay($year),
            $this->getSecondChristmasDay($year),
        ];
    }

    private function getChristmasEve(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('23 december %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Kerstavond',
            false,
            self::$countryCode
        );
    }

    private function getFirstChristmasDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('24 december %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Eerste Kerstdag',
            true,
            self::$countryCode
        );
    }

    private function getSecondChristmasDay(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('25 december %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Tweede Kerstdag',
            true,
            self::$countryCode
        );
    }

    private function getNewYearsEve(int $year): GeneratedNationalHoliday
    {
        return new GeneratedNationalHoliday(
            DateTimeImmutable::createFromMutable(
                new DateTime(sprintf('31 december %s', $year), new DateTimeZone(static::$timezone))
            ),
            'Oudejaarsavond',
            false,
            self::$countryCode
        );
    }
}
