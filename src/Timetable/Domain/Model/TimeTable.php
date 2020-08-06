<?php

declare(strict_types=1);

namespace App\Timetable\Domain\Model;

class TimeTable
{
    private array $rows = [];

    public function addRow(array $row): void
    {
        $this->rows[] = $row;
    }

    public function getHeaders(): array
    {
        return ['Date', 'Tasks', 'Time'];
    }

    public function getRows():array
    {
        return $this->rows;
    }
}
