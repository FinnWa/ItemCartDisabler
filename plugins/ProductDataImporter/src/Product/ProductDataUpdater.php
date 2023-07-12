<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

final class ProductDataUpdater
{

    public function __construct(private EntityRepository $entityRepository)
    {
    }

    public function update(ProductCollection $productCollection): void
    {
        foreach ($productCollection as $product) {
            $searchedProduct = $this->findByProductNumber($product);

            $data = [
                'id' => $searchedProduct->getId(),
                'name' => $product->productName,
                'taxId' => 'b6e827014e184c7d82ffdc25b4e446ad',
                'stock' => 1000,
                'price' => [
                    [
                        'currencyId' => 'b7d2554b0ce847cd82f3ac9bd1c0dfca',
                        'gross' => $product->productBruttoPrice,
                        'net' => $product->productNettoPrice,
                        'linked' => true,
                    ]
                ],
                'productNumber' => $product->productNumber,
                'description' => $product->productDescription,
                'visibility' => [
                    [
                        'salesChannelId' => '9e1c99c3c5c546ddaf9c6825a5b257b6',
                        'visibility' => ProductVisibilityDefinition::VISIBILITY_ALL,
                    ]
                ]
            ];

            $this->entityRepository->update([$data], Context::createDefaultContext());
        }
    }

    public function findByProductNumber(Product $product): ProductEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productNumber', $product->productNumber));
        $product = $this->entityRepository->search($criteria, Context::createDefaultContext())->first();

        return $product;
    }
}
