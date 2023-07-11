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

    public function validate(ProductCollection $productCollection): void
    {
        $brokenProductCollection = new BrokenProductCollection();
        foreach ($productCollection as $product) {
            if (!$this->hasImage($product) || !$this->hasProductNumber($product) || !$this->hasProductName($product)) {
                if (!$this->hasImage($product)) {
                    $product->productImageUrl = 'MISSING';
                }

                if (!$this->hasProductNumber($product)) {
                    $product->productNumber = 'MISSING';
                }

                if (!$this->hasProductName($product)) {
                    $product->productName = 'MISSING';
                }
                $brokenProductCollection->add($product);
                $productCollection->remove($product);
            }


        }
        $this->writeBrokenProductsToCsv($brokenProductCollection);
    }

    public function hasImage(Product $product): bool
    {
        if ($product->productImageUrl === '') {
            return false;
        }
        return true;
    }

    public function hasProductNumber(Product $product): bool
    {
        if ($product->productNumber === '') {
            return false;
        }
        return true;
    }

    public function hasProductName(Product $product): bool
    {
        if ($product->productName === '') {
            return false;
        }
        return true;
    }

    public function writeBrokenProductsToCsv(BrokenProductCollection $brokenProductCollection): void
    {
        $products = [];
        foreach ($brokenProductCollection as $brokenProduct) {
            $products[] = [
                'ID' => $brokenProduct->id,
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
