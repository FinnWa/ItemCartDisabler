<?php

namespace ItemCartDisabler\Fixer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ItemCartDisabler\Fixer\FixTemperatureCustomFields;


class CommandFixProductCustomFields extends Command
{
    private $fixTemperatureCustomFields;

    public function __construct(FixTemperatureCustomFields $fixTemperatureCustomFields)
    {
        $this->fixTemperatureCustomFields = $fixTemperatureCustomFields;

        parent::__construct();
    }


    // Command name
    protected static $defaultName = 'fixProductCustomFields:fix-data';

    protected function configure(): void
    {
        $this->setDescription('Sets for ALL products the temperature in the customFields')
            ->addArgument('max', InputArgument::REQUIRED, 'Max Temperature')
            ->addArgument('min', InputArgument::REQUIRED, 'Min Temperature');
    }

    // Actual code executed in the command
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $max = $input->getArgument('max');
        $min = $input->getArgument('min');

        $this->fixTemperatureCustomFields->setTemperature($max, $min);

        $output->writeln("\n Max temperature has been set to: $max \n
        Min temperature has been set to $min");

        // Exit code 0 for success
        return 0;
    }
}