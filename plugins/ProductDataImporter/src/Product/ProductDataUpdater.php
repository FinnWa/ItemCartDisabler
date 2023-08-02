<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

final class ProductDataUpdater
{

    public function __construct(private EntityRepository $entityRepository, private ProductSearcher $productSearcher)
    {
    }

    public function update(ProductCollection $productCollection): void
    {
        foreach ($productCollection as $product) {
            $searchedProduct = $this->productSearcher->search($product);

            if ($searchedProduct !== null) {
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

                $this->entityRepository->upsert([$data], Context::createDefaultContext());
            }
        }
    }
}
