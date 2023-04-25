<?php

namespace ItemCartDisabler\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;
class ChangeWeatherStateTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'itemCartDisabler.change_weather_state_task';
    }

    public static function getDefaultInterval(): int
    {
        return 5; // 5secs
    }

}