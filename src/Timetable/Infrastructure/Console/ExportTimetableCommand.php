<?php

declare(strict_types=1);

namespace App\Timetable\Infrastructure\Console;

use App\Location\Domain\Model\Location;
use App\Location\Domain\Repository\LocationRepositoryInterface;
use App\Location\Domain\ValueObject\LocationId;
use App\System\Domain\Repository\Exception\NoResultException;
use App\Timetable\Domain\Service\TimeTableGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ExportTimetableCommand extends Command
{
    protected static $defaultName = 'timetable:export';

    private LocationRepositoryInterface $locationRepository;
    private TimeTableGenerator $timeTableGenerator;
    private QuestionHelper $questionHelper;

    private Location $location;
    private string $file;

    public function __construct(
        LocationRepositoryInterface $locationRepository,
        TimeTableGenerator $timeTableGenerator
    ){
        parent::__construct();
        $this->locationRepository = $locationRepository;
        $this->timeTableGenerator = $timeTableGenerator;
    }

    protected function configure()
    {
        $this
            ->addOption(
                'location',
                null,
                InputOption::VALUE_REQUIRED,
                'For which location do you want to export?',
                null
            )
            ->addOption(
                'file',
                null,
                InputOption::VALUE_OPTIONAL,
                'For what country do we need to generate holidays?',
                null
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');

        try {
            $this->location = $this->locationRepository->get(new LocationId((int)$input->getOption('location')));
        } catch (NoResultException $e) {
            $this->askLocation($input, $output);
        }
    }


    private function askLocation(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<error> Location could not be found in database.</error>');
        try {
            $answer = $this->questionHelper->ask($input, $output, new Question('<fg=cyan>Please enter the id of the location:</>'));

            $this->location = $this->locationRepository->get(new LocationId((int)$answer));
        } catch (NoResultException $e) {
            $this->askLocation($input, $output);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $timeTable = $this->timeTableGenerator->generate($this->location);

        $table = new Table($output);
        $table->setRows($timeTable);
        $table->render();

        return 0;
    }
}
