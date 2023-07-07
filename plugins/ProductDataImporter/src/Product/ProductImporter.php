<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductImporter
{
    private EntityRepository $entityRepository;
    private ProductCollection $productCollection;

    public function __construct(EntityRepository $entityRepository, ProductCollection $productCollection)
    {
        $this->entityRepository = $entityRepository;
        $this->productCollection = $productCollection;
    }

    public function update(ProductCollection $productCollection): void
    {
        $updates = [];
        foreach ($productCollection as $product) {
            $updates[] = [
                'id' => Uuid::randomhex(),
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
        }

        //TODO aus dem Context die ids holen
        //$this->entityRepository->create($updates, Context::createDefaultContext());
    }
}
