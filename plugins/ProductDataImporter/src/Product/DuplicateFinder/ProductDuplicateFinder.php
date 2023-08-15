<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\DuplicateFinder;

use ProductDataImporter\Product\CsvWriter;
use ProductDataImporter\Product\ProductImport\Product;
use ProductDataImporter\Product\ProductSearch\ProductSearcher;

final class ProductDuplicateFinder
{
    public const DUPLICATED_PRODUCT_CSV_PATH = '/duplicatedProducts.csv';

    public function __construct(
        private readonly CsvWriter $csvWriter,
        private readonly ProductSearcher $productSearcher
    ) {
    }

    public function find(Product $product): bool
    {
        $duplicateCollection = new DuplicatedProductCollection();

        if ($this->productSearcher->search($product) === null) {
            return false;
        }

        $duplicatedProduct = $this->createDuplicateProduct($product);
        $duplicateCollection->add($duplicatedProduct);
        $this->csvWriter->write($duplicateCollection, self::DUPLICATED_PRODUCT_CSV_PATH);
        return true;
    }

    public function createDuplicateProduct(Product $product): DuplicatedProduct
    {
        return new DuplicatedProduct(
            $product->productNumber,
            $product->productName,
            $product->productDescription,
            $product->productNettoPrice,
            $product->productBruttoPrice,
            $product->productImageUrl
        );
    }
}
