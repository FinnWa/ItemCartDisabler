<?php

namespace ItemCartDisabler\Fixer;
use ItemCartDisabler\Product\GetProducts;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class FixTemperatureCustomFields
{
    const FITS_WEATHER = true;
    private GetProducts $products;
    private EntityRepository $productRepository;

    public function __construct(EntityRepository $productRepository, GetProducts $products)
    {
        $this->productRepository = $productRepository;
        $this->products = $products;
    }

    public function setTemperature(int $max, int $min): void
    {
        $products = $this->products->getProducts();

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
        //TODO Warum wird nur nach dem zweiten, nach dem ausführen des commands, der richtige Dump angezeigt
        dump($products);
    }
}