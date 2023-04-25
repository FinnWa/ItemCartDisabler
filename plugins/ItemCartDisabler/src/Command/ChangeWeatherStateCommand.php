<?php

namespace ItemCartDisabler\Command;
use ItemCartDisabler\Fixer\FixTemperatureCustomFields;
use ItemCartDisabler\Weather\ChangeWeatherState;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeWeatherStateCommand extends Command
{
    private $changeWeatherState;

    public function __construct(ChangeWeatherState $changeWeatherState)
    {
        $this->changeWeatherState = $changeWeatherState;

        parent::__construct();
    }

    protected static $defaultName = 'changeWeatherState:change-data';

    protected function configure(): void
    {
        $this->setDescription('Sets for ALL products the weather state in the customFields');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->changeWeatherState->changeFittingWeather();

        $output->writeln("\n Fitting state has been changed equal to the Weather State");

        // Exit code 0 for success
        return 0;
    }
}