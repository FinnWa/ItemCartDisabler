<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductImport;

use ProductDataImporter\Product\CsvWriter;


final class ProductValidator
{

    public const BROKEN_PRODUCT_CSV_PATH = '/brokenProducts.csv';

    public function __construct(private readonly CsvWriter $csvWriter)
    {
    }

    public function validate(Product $product): bool
    {
        $brokenProductCollection = new BrokenProductCollection();
        $brokenProduct = $this->createBrokenProduct($product);

        if (!$product->hasImage() || !$product->hasProductNumber() || !$product->hasProductName()) {
            if (!$product->hasImage()) {
                $brokenProduct->productImageUrl[] = 'MISSING';
            }

            if (!$product->hasProductNumber()) {
                $brokenProduct->productNumber = 'MISSING';
            }

            if (!$product->hasProductName()) {
                $brokenProduct->productName = 'MISSING';
            }
            $brokenProductCollection->add($brokenProduct);

            $this->csvWriter->write($brokenProductCollection, self::BROKEN_PRODUCT_CSV_PATH);
            return false;
        }

        return true;
    }

    public function createBrokenProduct(Product $product): BrokenProduct
    {
        return new BrokenProduct(
            $product->productNumber,
            $product->productName,
            $product->productDescription,
            $product->productNettoPrice,
            $product->productBruttoPrice,
            $product->productImageUrl
        );
    }
}
