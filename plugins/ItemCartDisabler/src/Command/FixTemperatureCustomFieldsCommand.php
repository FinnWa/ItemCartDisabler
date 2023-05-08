<?php

namespace ItemCartDisabler\Command;

use ItemCartDisabler\Fixer\FixTemperatureCustomFields;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;


class FixTemperatureCustomFieldsCommand extends Command
{
    private FixTemperatureCustomFields $fixTemperatureCustomFields;

    public function __construct( FixTemperatureCustomFields $fixTemperatureCustomFields)
    {
        $this->fixTemperatureCustomFields = $fixTemperatureCustomFields;
        parent::__construct();
    }

    protected static $defaultName = 'fixProductCustomFields:fix-data';

    protected function configure(): void
    {
        $this->setDescription('Sets for ALL products the temperature in the customFields')
            ->addArgument('max', InputArgument::REQUIRED, 'Max Temperature')
            ->addArgument('min', InputArgument::REQUIRED, 'Min Temperature');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $max = $input->getArgument('max');
        //Assert::integer($max, 'argument max must be of type int');
        $min = $input->getArgument('min');
        //Assert::integer($min, 'argument min must be of type int');

        $this->fixTemperatureCustomFields->setTemperature($max, $min);

        $output->writeln(sprintf('Max temperature has been set to: %s%sMin temperature has been set to %s',
            $max,
            PHP_EOL,
            $min));

        return self::SUCCESS;
    }
}