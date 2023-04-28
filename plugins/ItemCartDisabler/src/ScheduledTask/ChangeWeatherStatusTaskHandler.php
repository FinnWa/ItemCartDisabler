<?php

namespace ItemCartDisabler\ScheduledTask;

use ItemCartDisabler\Weather\ChangeWeatherStatus;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;

class ChangeWeatherStatusTaskHandler extends ScheduledTaskHandler
{

    public function __construct(EntityRepositoryInterface $scheduledTaskRepository, ChangeWeatherStatus $changeWeatherStatus)
    {
        $this->changeWeatherStatus = $changeWeatherStatus;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [ ChangeWeatherStatusTask::class ];
    }

    public function run(): void
    {
        $this->changeWeatherStatus->changeFittingWeather();
        echo "ScheduledTask run";
    }
}