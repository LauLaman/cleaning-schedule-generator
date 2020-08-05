<?php

declare(strict_types=1);

namespace App\Timetable\Domain\Service;

use App\Location\Domain\Model\Location;

class TimeTableGenerator
{
    public function generate(Location $location): array
    {
        return [
            ['Date', 'Tasks', 'Time'],
        ];
    }
}
