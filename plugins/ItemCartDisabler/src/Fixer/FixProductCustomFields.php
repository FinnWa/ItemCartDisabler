<?php

namespace ItemCartDisabler\Fixer;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Twig\Extension\AbstractExtension;
use ItemCartDisabler\Fixer\CommandFixProductCustomFields;
use Twig\TwigFunction;

class FixProductCustomFields extends AbstractExtension
{

    const FITS_WEATHER = true;
    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('fix_data', [$this, 'fixData'])
        ];
    }

    public function fixData()
    {
        $min = 0.0;
        $max = 0.0;
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

            if ($result[$i]['customFields'] === null) {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result[$i]['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());
            }

            if ($result[$i]['customFields']['custom_fits_weather_max_temp'] === 35.0 &&
                $result[$i]['customFields']['custom_fits_weather_min_temp'] === 20.0
            ) {
                $this->productRepository->upsert(
                    [
                        [
                            'id' => $result[$i]['id'],
                            'customFields' => $customFields,
                        ]
                    ], Context::createDefaultContext());
            }
            $i++;
        }
        return $result;
    }

}