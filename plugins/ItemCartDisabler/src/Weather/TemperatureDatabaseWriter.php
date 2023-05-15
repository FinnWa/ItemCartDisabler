<?php

declare(strict_types=1);

namespace ItemCartDisabler\Weather;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class TemperatureDatabaseWriter
{
    private EntityRepository $entityRepository;
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function write(ProductEntity $product, int $maxTemperature, int $minTemperature): void
    {
        $this->entityRepository->upsert(
            [
                [
                    'id' => $product->getId(),
                    'customFields' => [
                        'custom_fits_weather_max_temp' => $maxTemperature,
                        'custom_fits_weather_min_temp' => $minTemperature
                    ],
                ]
            ], Context::createDefaultContext());

    }
}