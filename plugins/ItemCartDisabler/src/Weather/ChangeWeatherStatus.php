<?php

namespace ItemCartDisabler\Weather;

use ItemCartDisabler\Product\GetProducts;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;


class ChangeWeatherStatus
{
    private EntityRepository $productRepository;
    private GetWeatherDataAPI $getWeatherDataAPI;
    private GetProducts $products;

    public function __construct(EntityRepository $productRepository, GetWeatherDataAPI $getWeatherDataAPI, GetProducts $products)
    {
        $this->productRepository = $productRepository;
        $this->getWeatherDataAPI = $getWeatherDataAPI;
        $this->products = $products;
    }


    public function changeFittingWeather(): void
    {
        $results = $this->getWeatherDifferences();
        //TODO unnötige Upserts entfernen, wenn schon richtiger state vorhanden ist

        foreach ($results as $result) {

            if ($result['isInWeatherCondition'] === true) {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result['id'],
                            'customFields' => ['custom_fits_weather_' => true],
                        ]
                    ], Context::createDefaultContext());
                continue;
            }

            $this->productRepository->upsert(
                [
                    [
                        'id' => $result['id'],
                        'customFields' => ['custom_fits_weather_' => false],
                    ]
                ], Context::createDefaultContext());
        }
    }

    public function getWeatherDifferences(): array
    {
        $differences = [];
        $temperature = $this->getWeatherDataAPI->getTemperature(
            $this->getWeatherDataAPI->getWeatherData(
                $this->getWeatherDataAPI->getLocation()
            )
        );

        $results = $this->products->getProducts();

        foreach ($results as $result) {
            $minTemp = $result['customFields']['custom_fits_weather_min_temp'];
            $maxTemp = $result['customFields']['custom_fits_weather_max_temp'];
            $result['isInWeatherCondition'] = false;

            if (($minTemp >= $temperature - 10 && $minTemp <= $temperature + 10) &&
                ($maxTemp >= $temperature - 10 && $maxTemp <= $temperature + 10)
            ) {
                $result['isInWeatherCondition'] = true;
            }
            $differences[] = $result;
        }


        return $differences;
    }
}