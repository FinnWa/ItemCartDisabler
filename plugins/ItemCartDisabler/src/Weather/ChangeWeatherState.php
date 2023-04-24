<?php

namespace ItemCartDisabler\Weather;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ChangeWeatherState extends AbstractExtension
{

    public function __construct(EntityRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('read_data', [$this, 'readData'])
        ];
    }


    public function readData()
    {
        $result = [];

        $i = 0;

        $products = $this->productRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($products as $product) {

            $result[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'customFields' => $product->getCustomFields(),
            ];

        }
        return $result;

        //return $result;
    }


}