<?php

declare(strict_types=1);

namespace ItemCartDisabler\Command;

use ItemCartDisabler\Weather\FitsWeatherCustomFieldUpdater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeWeatherStatusCommand extends Command
{
    private FitsWeatherCustomFieldUpdater $customFieldUpdater;

    public function __construct(FitsWeatherCustomFieldUpdater $customFieldUpdater)
    {
        $this->customFieldUpdater = $customFieldUpdater;
        parent::__construct();
    }

    protected static $defaultName = 'changeWeatherStatus:change-data';

    protected function configure(): void
    {
        $this->setDescription('Sets for ALL products the weather state in the customFields');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->customFieldUpdater->update();

        $output->writeln('Fitting state has been changed equal to the Weather State');

        return 0;
    }
}