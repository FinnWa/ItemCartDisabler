<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class InputParser
{
    public function __construct(private Serializer $serializer)
    {
    }

    public function parse(string $path): ProductCollection
    {
        $productCollection = new ProductCollection();

        $productsData = $this->serializer->decode(file_get_contents($path), CsvEncoder::FORMAT, ['no_headers']);

        foreach ($productsData as $productData) {
            $product = new Product(
                (string)$productData['NUMBER'],
                $productData['NAME'],
                $productData['DESCRIPTION'],
                (float)$productData['PRICE_NET'],
                (float)$productData['PRICE_NET']
            );

            $productCollection->add($product);
        }

        return $productCollection;
    }

}
