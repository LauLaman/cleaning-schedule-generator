<?php

declare(strict_types=1);

namespace App\NationalHoliday\Infrastructure\Console;

use App\NationalHoliday\Domain\Command\GenerateForYearCommand;
use App\NationalHoliday\Domain\Service\Generator\DutchNationalHolidayNationalHolidayGenerator;
use App\System\Domain\MessageBus\CommandBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateHolidaysCommand extends Command
{
    protected static $defaultName = 'generate:holidays';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->addOption(
                'year',
                null,
                InputOption::VALUE_REQUIRED,
                'For what year do we need to generate holidays?',
                2020
            )
            ->addOption(
                'country',
                null,
                InputOption::VALUE_REQUIRED,
                'For what country do we need to generate holidays?',
                'NLD'
            )
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (int)$input->getOption('year');
        $country = $input->getOption('country');

        $output->writeln(
            sprintf('Generating holidays for <comment>%s</comment> and <comment>%s</comment>... Please wait..', $year, $country)
        );

        $this->commandBus->dispatch(
            new GenerateForYearCommand($year, $country)
        );

        $output->writeln('<info>All done!</info>');

        return 0;
    }
}
