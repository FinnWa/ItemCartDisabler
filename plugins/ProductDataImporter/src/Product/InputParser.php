<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use ProductDataImporter\Product\ProductImport\Product;
use ProductDataImporter\Product\ProductImport\ProductCollection;
use ProductDataImporter\Product\ProductImport\ProductValidator;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class InputParser
{
    public function __construct(private Serializer $serializer, private ProductValidator $productValidator)
    {
    }

    public function parse(string $path): ProductCollection
    {
        $productCollection = new ProductCollection();

        $productsData = $this->serializer->decode(file_get_contents($path), CsvEncoder::FORMAT,
            ['no_headers', CsvEncoder::DELIMITER_KEY => ';']);

        foreach ($productsData as $productData) {
            $product = new Product(
                (string)$productData['NUMBER'],
                $productData['NAME'],
                $productData['DESCRIPTION'],
                (float)$productData['PRICE_NET'],
                (float)$productData['PRICE_NET'],
                (string)$productData['IMAGE'],
                Uuid::randomHex()
            );

            if ($this->productValidator->validate($product)) {
                $productCollection->add($product);
            }
        }
        return $productCollection;
    }

}
