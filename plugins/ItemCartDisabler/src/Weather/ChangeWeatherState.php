<?php

namespace ItemCartDisabler\Weather;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class ChangeWeatherState
{

    const WEATHER_TEMPERATURE = 90;

    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function changeFittingWeather()
    {
        $results = $this->getWeatherDifferences();
        //TODO unnötige Upserts entfernen, wenn schon richtiger state vorhanden ist

        foreach ($results as $result){

            if($result['minDiff'] === false || $result['maxDiff'] === false) {

                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result['id'],
                            'customFields' => ['custom_fits_weather_' => false],
                        ]
                    ], Context::createDefaultContext());
            } else {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result['id'],
                            'customFields' => ['custom_fits_weather_' => true],
                        ]
                    ], Context::createDefaultContext());
            }
        }
        return $results;
    }

    public function getWeatherDifferences(){
        $differences = [];

        $products = $this->productRepository->search(new Criteria(), Context::createDefaultContext());
        foreach ($products as $product) {
            $results[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'customFields' => $product->getCustomFields(),
            ];
        }

        foreach ($results as $result){
            $minDiff = $result['customFields']['custom_fits_weather_min_temp'];
            $maxDiff = $result['customFields']['custom_fits_weather_max_temp'];
            $result['maxDiff'] = false;
            $result['minDiff'] = false;

            if(abs($minDiff - +(self::WEATHER_TEMPERATURE)) <= 10){
                $result['minDiff'] = true;
            }

            if(abs($maxDiff - +(self::WEATHER_TEMPERATURE)) <= 10){
                $result['maxDiff'] = true;
            }
            $differences[] = $result;
        }

        return $differences;
    }


}