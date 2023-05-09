<?php

declare(strict_types=1);

namespace ItemCartDisabler\Product;

use Shopware\Core\Content\Product\ProductEntity;

final class ProductsToArrayMapper
{
    /**
     * @param array<ProductEntity> $products
     * @return array<array<string, mixed>>
     */
    public function map(array $products): array
    {
        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'customFields' => $product->getCustomFields(),
            ];
        }

        return $results;
    }

}