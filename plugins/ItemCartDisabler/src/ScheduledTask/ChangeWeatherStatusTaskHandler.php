<?php

namespace ItemCartDisabler\ScheduledTask;

use ItemCartDisabler\Weather\FitsWeatherCustomFieldUpdater;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;

class ChangeWeatherStatusTaskHandler extends ScheduledTaskHandler
{


    private FitsWeatherCustomFieldUpdater $fitsWeatherCustomFieldUpdater;

    public function __construct(EntityRepositoryInterface $scheduledTaskRepository, FitsWeatherCustomFieldUpdater $fitsWeatherCustomFieldUpdater)
    {
        parent::__construct($scheduledTaskRepository);
        $this->scheduledTaskRepository = $scheduledTaskRepository;
        $this->fitsWeatherCustomFieldUpdater = $fitsWeatherCustomFieldUpdater;
    }

    public static function getHandledMessages(): iterable
    {
        return [ChangeWeatherStatusTask::class];
    }

    public function run(): void
    {
        $this->fitsWeatherCustomFieldUpdater->update();
        echo "ScheduledTask run";
    }
}