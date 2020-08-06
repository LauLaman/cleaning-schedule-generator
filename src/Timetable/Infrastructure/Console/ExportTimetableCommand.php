<?php

declare(strict_types=1);

namespace App\Timetable\Infrastructure\Console;

use App\Location\Domain\Model\Location;
use App\Location\Domain\Repository\LocationRepositoryInterface;
use App\Location\Domain\ValueObject\LocationId;
use App\System\Domain\Repository\Exception\NoResultException;
use App\Timetable\Domain\Model\TimeTable;
use App\Timetable\Domain\Service\TimeTableGenerator;
use DateTimeImmutable;
use League\Csv\Writer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\MissingInputException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ExportTimetableCommand extends Command
{
    protected static $defaultName = 'timetable:export';

    private LocationRepositoryInterface $locationRepository;
    private TimeTableGenerator $timeTableGenerator;
    private QuestionHelper $questionHelper;

    private bool $quiet;
    private bool $interact;

    private Location $location;
    private ?string $file;


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
        error_reporting(~E_USER_DEPRECATED);

        $this
            ->addOption(
                'location',
                'l',
                InputOption::VALUE_REQUIRED,
                'For which location do you want to export?',
                null
            )
            ->addOption(
                'file',
                'f',
                InputOption::VALUE_OPTIONAL,
                'file we want to write data to',
                null
            )
            ->addOption(
                'quiet',
                'q',
                InputOption::VALUE_NONE,
                'Dont print preview to screen.',
                null
            )
            ->addOption(
                'no-interaction',
                'n',
                InputOption::VALUE_NONE,
                'Do not ask for confirmation.',
                null
            )
            ->addOption(
                'start',
                null,
                InputOption::VALUE_OPTIONAL,
                'Start date of the timetale',
                null
            )
            ->addOption(
                'end',
                null,
                InputOption::VALUE_OPTIONAL,
                'Start date of the timetale',
                null
            )
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->questionHelper = $this->getHelper('question');

        $this->quiet = $input->getOption('quiet');
        $this->interact = !$input->getOption('no-interaction');

        try {
            $this->location = $this->locationRepository->get(new LocationId((int)$input->getOption('location')));
        } catch (NoResultException $e) {
            if (!$this->interact) {
                throw new MissingInputException('Location is not set.');
            }

            $this->askLocation($input, $output);
        }

        $this->file = $input->getOption('file');

        if (!$this->isFilePathValid() && !$this->interact) {
            throw new MissingInputException('File is not set or invalid. Make sure the directory exists.');
        }

        if (!$this->quiet) {
            $table = new Table($output);
            $table->setHeaderTitle('Location');
            $table->setHeaders(['Name', 'Address']);
            $table->setRows([
                [$this->location->getName(), $address = $this->location->getAddress()->getFormatted()],
            ]);
            $table->render();
            $output->writeln('');
        }
    }

    private function askLocation(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<error>Location could not be found in database.</error>');
        try {
            $answer = $this->questionHelper->ask($input, $output, new Question('<fg=cyan>Please enter the id of the location:</> '));

            $this->location = $this->locationRepository->get(new LocationId((int)$answer));
        } catch (NoResultException $e) {
            $this->askLocation($input, $output);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $start = $this->getStartDate($input);
        $end = $this->getEndDate($input , $start);

        $timeTable = $this->timeTableGenerator->generate($this->location, $start, $end);

        if (!$this->quiet) {
            $table = new Table($output);
            $table->setHeaderTitle('TimeTable');
            $table->setHeaders($timeTable->getHeaders());
            $table->setRows($timeTable->getRows());
            $table->render();
        }

        if ($this->shouldWriteToFile($input, $output)) {
            $this->writeToFile($timeTable);
        }

        return 0;
    }

    public function shouldWriteToFile(InputInterface $input, OutputInterface $output): bool
    {
        if ($this->isFilePathValid()) {
            return true;
        }

        if (!$this->interact) {
            throw new MissingInputException('File is not set or invalid. Make sure the directory exists..');
        }

        $question = new ConfirmationQuestion('Do you want to write a CSV file? [y/N] ', false);
        if (!$this->questionHelper->ask($input, $output, $question)) {
            return false;
        }

        $this->askFileLocation($input, $output);

        return $this->shouldWriteToFile($input, $output);

    }

    private function askFileLocation(InputInterface $input, OutputInterface $output): void
    {
        if (!$this->interact) {
            throw new MissingInputException('File is not set or invalid. Make sure the directory exists.');
        }

        $output->writeln('<error>File is not set or invalid. Make sure the directory exists.</error>');

        $this->file = $this->questionHelper->ask($input, $output, new Question('<fg=cyan>Please enter the file location:</> '));

        if (!$this->isFilePathValid()) {
            $this->askFileLocation($input, $output);
        }
    }

    private function isFilePathValid(): bool
    {
        if (null === $this->file) {
            return false;
        }

        return is_dir(dirname($this->file).'/');
    }

    private function writeToFile(TimeTable $timeTable): void
    {
        $csv = Writer::createFromString();
        $csv->insertOne($timeTable->getHeaders());
        $csv->insertAll($timeTable->getRows());

        file_put_contents($this->file, $csv->getContent());
    }

    private function getStartDate(InputInterface $input): DateTimeImmutable
    {
        if ($start = $input->getOption('start')) {
            return new DateTimeImmutable($start);
        }

        return new DateTimeImmutable('first day of next month');
    }

    private function getEndDate(InputInterface $input, DateTimeImmutable $start)
    {
        if ($end = $input->getOption('end')) {
            return new DateTimeImmutable($end);
        }

        return $start->modify('+ 3months')->modify('last day');
    }
}
