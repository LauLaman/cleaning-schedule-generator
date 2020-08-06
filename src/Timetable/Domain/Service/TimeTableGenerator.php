<?php

declare(strict_types=1);

namespace App\Timetable\Domain\Service;

use App\Location\Domain\Model\Location;
use App\Timetable\Domain\Model\CleaningTask;
use App\Timetable\Domain\Model\TimeTable;
use DateInterval;
use DatePeriod;
use DateTimeInterface;

class TimeTableGenerator
{
    private TimeTable $timeTable;

    public function __construct()
    {
        $this->timeTable = new TimeTable();
    }

    public function generate(Location $location, DateTimeInterface $start, DateTimeInterface $end): TimeTable
    {
        /* We need to add one day in order to iterate over the last day of our period */
        $end = $end->modify( '+1 day' );

        $datePeriod = new DatePeriod($start, new DateInterval('P1D'), $end);

        $cleaningTasks = $this->getCleaningTasks($location);

        foreach ($datePeriod as $date) {
            $this->addDate($date, ...$cleaningTasks);
        }

        return $this->timeTable;
    }

    private function addDate(DateTimeInterface $date, CleaningTask ...$cleaningTasks)
    {
        $tasksToPerform = [];
        $timeToCompleteTasks = 0;

        foreach ($cleaningTasks as $cleaningTask) {
            if (!$cleaningTask->shouldPerformOnDate($date)) {
                continue;
            }

            if (array_keys($tasksToPerform, $cleaningTask->getCleaningServiceId()->getValue())) {
                continue;
            }

            $tasksToPerform[$cleaningTask->getCleaningServiceId()->getValue()] = $cleaningTask->getName();
            $timeToCompleteTasks = $timeToCompleteTasks + $cleaningTask->getTimeInMinutes();
        }

        $this->timeTable->addRow(
            [
                $date->format('Y-m-d'),
                implode(', ', $tasksToPerform),
                $this->formatMinutes($timeToCompleteTasks),
            ]
        );
    }

    /**
     * @return CleaningTask[]
     */
    private function getCleaningTasks(Location $location): array
    {
        $tasks = [];

        foreach ($location->getSubscriptions() as $subscription) {
            $tasks[] = new CleaningTask($subscription);
        }

        return $tasks;
    }

    private function formatMinutes(int $time): string
    {
        if ($time < 1) {
            return '';
        }

        $hours = floor($time / 60);
        $minutes = ($time % 60);

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
