<?php

namespace ItemCartDisabler\Fixer;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class FixTemperatureCustomFields
{
    const FITS_WEATHER = true;
    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function fixData(int $max, int $min): array
    {
        // TODO: refactor if statements and foreach, product upserts and include getData()
        $result = [];

        $i = 0;

        $products = $this->productRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($products as $product) {

            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'customFields' => $product->getCustomFields(),
            ];

            $customFields = [
                "custom_fits_weather_" => self::FITS_WEATHER,
                "custom_fits_weather_max_temp" => $max,
                "custom_fits_weather_min_temp" => $min,
            ];

            if ($result[$i]['customFields'] === null) {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result[$i]['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());
            }

            //Wird nicht mehr gebraucht, war für spezielles Item
            /*
            if ($result[$i]['customFields']['custom_fits_weather_max_temp'] === self::MAX_TEMPERATURE &&
                $result[$i]['customFields']['custom_fits_weather_min_temp'] === self::MIN_TEMPERATURE
            ) {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result[$i]['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());
            } */
            $i++;
        }
        return $result;
    }

    public function setTemperature(int $max, int $min): array
    {
        // TODO: refactor if statements and foreach
        $result = [];

        $i = 0;

        $products = $this->productRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($products as $product) {

            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'customFields' => $product->getCustomFields(),
            ];

            $customFields = [
                "custom_fits_weather_" => self::FITS_WEATHER,
                "custom_fits_weather_max_temp" => $max,
                "custom_fits_weather_min_temp" => $min,
            ];

                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result[$i]['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());

            $i++;
        }
        return $result;
    }
}