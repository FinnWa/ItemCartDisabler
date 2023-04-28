<?php

namespace ItemCartDisabler\Command;
use ItemCartDisabler\Weather\GetWeatherDataAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

class GetWeatherDataAPICommand extends Command
{
    private $getWeatherDataAPI;

    public function __construct(GetWeatherDataAPI $getWeatherDataAPI)
    {
        $this->getWeatherDataAPI = $getWeatherDataAPI;

        parent::__construct();
    }

    protected static $defaultName = 'getWeatherDataAPI:get-temperature';

    protected function configure(): void
    {
        $this->setDescription('Gets temperature for the given state');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $state = $this->getWeatherDataAPI->getLocation();
        Assert::string($state, 'Location must be a string');
        $data = $this->getWeatherDataAPI->getWeatherData($state);
        Assert::string($data, 'Weather data must be a string/json');
        $temperature = $this->getWeatherDataAPI->getTemperature($data);
        Assert::float($temperature, 'Temperature must be a float');

        $output->writeln(sprintf('Temperate for %s is: %s', $state, $temperature));

        return 0;
    }

}