<?php

namespace ItemCartDisabler\Command;
use ItemCartDisabler\Weather\GetWeatherDataAPI;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

class GetWeatherDataAPICommand extends Command
{
    private GetWeatherDataAPI $getWeatherDataAPI;
    private SystemConfigService $configService;

    public function __construct(GetWeatherDataAPI $getWeatherDataAPI, SystemConfigService $configService)
    {
        $this->getWeatherDataAPI = $getWeatherDataAPI;
        parent::__construct();
        $this->configService = $configService;
    }

    protected static $defaultName = 'getWeatherDataAPI:get-temperature';

    protected function configure(): void
    {
        $this->setDescription('Gets temperature for the given state');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $location = $this->configService->get('ItemCartDisabler.config.weatherLocation');
        Assert::string($location, 'Location has to be a string');
        $data = $this->getWeatherDataAPI->getWeatherData();
        Assert::isArray($data, 'Weather data must be a array');
        $temperature = $this->getWeatherDataAPI->getTemperature();
        Assert::float($temperature, 'Temperature must be a float');

        $output->writeln(sprintf('Temperate for %s is: %s', $location, $temperature));

        return 0;
    }

}