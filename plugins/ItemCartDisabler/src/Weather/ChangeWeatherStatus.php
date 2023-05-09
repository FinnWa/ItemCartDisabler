<?php

namespace ItemCartDisabler\Weather;

use ItemCartDisabler\Product\ProductsToArrayMapper;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;


class ChangeWeatherStatus
{
    private EntityRepository $productRepository;
    private GetWeatherDataAPI $getWeatherDataAPI;
    private ProductsToArrayMapper $products;

    public function __construct(EntityRepository $productRepository, GetWeatherDataAPI $getWeatherDataAPI, ProductsToArrayMapper $products)
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
        $temperature = $this->getWeatherDataAPI->getTemperature();

        $products = $this->products->map($this->productRepository->search(new Criteria(), Context::createDefaultContext()));

        foreach ($products as $product) {
            $minTemp = $product['customFields']['custom_fits_weather_min_temp'];
            $maxTemp = $product['customFields']['custom_fits_weather_max_temp'];
            $product['isInWeatherCondition'] = false;

            if (($minTemp >= $temperature - 10 && $minTemp <= $temperature + 10) &&
                ($maxTemp >= $temperature - 10 && $maxTemp <= $temperature + 10)
            ) {
                $product['isInWeatherCondition'] = true;
            }
            $differences[] = $product;
        }


        return $differences;
    }
}