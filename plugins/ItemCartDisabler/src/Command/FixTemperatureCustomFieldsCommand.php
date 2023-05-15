<?php

declare(strict_types=1);

namespace ItemCartDisabler\Command;

use ItemCartDisabler\Weather\TemperatureCustomFieldUpdater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;


class FixTemperatureCustomFieldsCommand extends Command
{


    private TemperatureCustomFieldUpdater $temperatureCustomFieldUpdater;

    public function __construct(TemperatureCustomFieldUpdater $temperatureCustomFieldUpdater)
    {
        parent::__construct();

        $this->temperatureCustomFieldUpdater = $temperatureCustomFieldUpdater;
    }

    protected static $defaultName = 'fixProductCustomFields:fix-data';

    protected function configure(): void
    {
        $this->setDescription('Sets for ALL products the temperature in the customFields')
            ->addArgument('maxTemperature', InputArgument::REQUIRED, 'Max Temperature')
            ->addArgument('minTemperature', InputArgument::REQUIRED, 'Min Temperature');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Todo Warum geht int nicht
        $maxTemperatureInput = $input->getArgument('maxTemperature');
        Assert::numeric($maxTemperatureInput, 'max must be numeric');
        $maxTemperature = (int)$maxTemperatureInput;

        $minTemperatureInput = $input->getArgument('minTemperature');
        Assert::numeric($minTemperatureInput, 'max must be numeric');
        $minTemperature = (int)$minTemperatureInput;

        $this->temperatureCustomFieldUpdater->update($maxTemperature, $minTemperature);

        $output->writeln(sprintf('Max temperature has been set to: %s%sMin temperature has been set to %s',
            $maxTemperature,
            PHP_EOL,
            $minTemperature));

        return self::SUCCESS;
    }
}