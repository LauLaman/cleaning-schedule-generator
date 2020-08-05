<?php

declare(strict_types=1);

namespace App\CleaningSchedule\Domain\ValueObject;

use Werkspot\Enum\AbstractEnum;


/**
 * @method static self weekly()
 * @method bool isWeekly()
 * @method static self monthly()
 * @method bool isMonthly()
 * @method static self dependent()
 * @method bool isDependent()
 */
class CleaningScheduleType extends AbstractEnum
{
    private const WEEKLY = 'WEEKLY';
    private const MONTHLY = 'MONTHLY';
    private const DEPENDENT = 'DEPENDENT';
}
