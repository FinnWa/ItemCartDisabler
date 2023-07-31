<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class ProductValidator
{
    public function __construct(private Serializer $serializer)
    {
    }

    public function validate(Product $product): bool
    {
        $brokenProductCollection = new BrokenProductCollection();
        $brokenProduct = $this->createBrokenProduct($product);

        if (!$product->hasImage() || !$product->hasProductNumber() || !$product->hasProductName()) {
            if (!$product->hasImage()) {
                $brokenProduct->productImageUrl = 'MISSING';
            }

            if (!$product->hasProductNumber()) {
                $brokenProduct->productNumber = 'MISSING';
            }

            if (!$product->hasProductName()) {
                $brokenProduct->productName = 'MISSING';
            }
            $brokenProductCollection->add($brokenProduct);
            //wann wird geschrieben bzw. wie am ende der liste?
            $this->writeBrokenProductsToCsv($brokenProductCollection);
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

    private function writeBrokenProductsToCsv(BrokenProductCollection $brokenProductCollection): void
    {
        $products = [];
        foreach ($brokenProductCollection as $brokenProduct) {
            $products[] = [
                'NUMBER' => $brokenProduct->productNumber,
                'NAME' => $brokenProduct->productName,
                'DESCRIPTION' => $brokenProduct->productDescription,
                'PRICE_NET' => $brokenProduct->productNettoPrice,
                'IMAGE' => $brokenProduct->productImageUrl,
            ];
        }
        file_put_contents(__DIR__ . '/brokenProducts.csv',
            $this->serializer->encode($products, 'csv', [CsvEncoder::DELIMITER_KEY => ';']));
    }
}
