<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\ValueObject;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self firstDayOfTheMonth()
 * @method bool isFirstDayOfTheMonth()
 * @method static self firstWorkingDayOfTheMonth()
 * @method bool isFirstWorkingDayOfTheMonth()
 * @method static self lastDayOfTheMonth()
 * @method bool isLastDayOfTheMonth()
 * @method static self lastWorkingDayOfTheMonth()
 * @method bool isLastWorkingDayOfTheMonth()
 */
class MonthlySchedule extends AbstractEnum
{
    private const FIRST_DAY_OF_THE_MONTH = 'FIRST_DAY_OF_THE_MONTH';
    private const FIRST_WORKING_DAY_OF_THE_MONTH = 'FIRST_WORKING_DAY_OF_THE_MONTH';
    private const LAST_DAY_OF_THE_MONTH = 'LAST_DAY_OF_THE_MONTH';
    private const LAST_WORKING_DAY_OF_THE_MONTH = 'LAST_WORKING_DAY_OF_THE_MONTH';
}
