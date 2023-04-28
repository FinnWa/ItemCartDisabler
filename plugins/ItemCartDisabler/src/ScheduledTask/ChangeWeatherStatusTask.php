<?php

namespace ItemCartDisabler\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;
class ChangeWeatherStatusTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'itemCartDisabler.change_weather_status_task';
    }

    public static function getDefaultInterval(): int
    {
        return 5; // 5secs
    }

}