<?php

namespace ItemCartDisabler\ScheduledTask;

use ItemCartDisabler\Weather\ChangeWeatherState;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;

class ChangeWeatherStateTaskHandler extends ScheduledTaskHandler
{

    public function __construct(EntityRepositoryInterface $scheduledTaskRepository, ChangeWeatherState $changeWeatherState)
    {
        $this->changeWeatherState = $changeWeatherState;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ ChangeWeatherStateTask::class ];
    }

    public function run(): void
    {
        $this->changeWeatherState->changeFittingWeather();
        echo "ScheduledTask run";
    }
}