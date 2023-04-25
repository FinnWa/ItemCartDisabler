<?php

namespace ItemCartDisabler\Command;
use ItemCartDisabler\Weather\GetWeatherDataAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeatherDataAPICommand extends Command
{
    private $getWeatherDataAPI;

    public function __construct(GetWeatherDataAPI $getWeatherDataAPI)
    {
        $this->getWeatherDataAPI = $getWeatherDataAPI;

        parent::__construct();
    }


    // Command name
    protected static $defaultName = 'getWeatherDataAPI:get-temperature';

    protected function configure(): void
    {
        $this->setDescription('Gets temperature for the given state');
    }

    // Actual code executed in the command
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $state = $this->getWeatherDataAPI->getLocation();
        $data = $this->getWeatherDataAPI->getWeatherData($state);
        $temperature = $this->getWeatherDataAPI->getTemperature($data);

        $output->writeln("\n Temperate for $state is: $temperature");

        // Exit code 0 for success
        return 0;
    }

}