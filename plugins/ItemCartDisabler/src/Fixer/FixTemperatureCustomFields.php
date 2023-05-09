<?php

namespace ItemCartDisabler\Fixer;
use ItemCartDisabler\Product\ProductsToArrayMapper;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class FixTemperatureCustomFields
{
    const FITS_WEATHER = true;
    private ProductsToArrayMapper $products;
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository, ProductsToArrayMapper $products)
    {
        $this->productRepository = $productRepository;
        $this->products = $products;
    }

    public function setTemperature(int $max, int $min): void
    {
        $products = $this->products->map($this->productRepository->search(new Criteria(), Context::createDefaultContext()));

        foreach ($products as $product) {

            $customFields = [
                "custom_fits_weather_" => self::FITS_WEATHER,
                "custom_fits_weather_max_temp" => $max,
                "custom_fits_weather_min_temp" => $min,
            ];

                $this->productRepository->upsert(
                    [
                        [
                            'id' => $product['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());
        }
    }
}