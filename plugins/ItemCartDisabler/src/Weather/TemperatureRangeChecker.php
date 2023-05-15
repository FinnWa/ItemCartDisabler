<?php

declare(strict_types=1);

namespace ItemCartDisabler\Weather;


use Shopware\Core\Content\Product\ProductEntity;

class TemperatureRangeChecker
{

    public function isInRange(ProductEntity $product, float $locationTemperature): bool
    {
        $productCustomFields = $product->getCustomFields();

        return $locationTemperature >= $productCustomFields['custom_fits_weather_min_temp'] &&
            $locationTemperature <= $productCustomFields['custom_fits_weather_max_temp'];
    }

}