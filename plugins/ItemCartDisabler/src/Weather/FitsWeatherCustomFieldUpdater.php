<?php

declare(strict_types=1);

namespace ItemCartDisabler\Weather;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class FitsWeatherCustomFieldUpdater
{
    private GetWeatherDataAPI $getWeatherDataAPI;
    private EntityRepository $entityRepository;
    private TemperatureRangeChecker $temperatureRangeChecker;
    private FitsWeatherDatabaseWriter $fitsWeatherDatabaseWriter;

    public function __construct(
        GetWeatherDataAPI         $getWeatherDataAPI,
        EntityRepository          $entityRepository,
        TemperatureRangeChecker   $temperatureRangeChecker,
        FitsWeatherDatabaseWriter $fitsWeatherDatabaseWriter
    )
    {
        $this->getWeatherDataAPI = $getWeatherDataAPI;
        $this->entityRepository = $entityRepository;
        $this->temperatureRangeChecker = $temperatureRangeChecker;
        $this->fitsWeatherDatabaseWriter = $fitsWeatherDatabaseWriter;
    }

    public function update(): void
    {
        $temperature = $this->getWeatherDataAPI->getTemperature();
        $products = $this->entityRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($products as $product) {
            $this->fitsWeatherDatabaseWriter->write(
                $product,
                $this->temperatureRangeChecker->isInRange($product, $temperature)
            );
        }
    }
}