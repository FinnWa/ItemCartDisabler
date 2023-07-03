<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class InputParser
{

    private ProductImporter $productImporter;

    public function __construct(ProductImporter $productImporter)
    {
        $this->productImporter = $productImporter;
    }

    public function parse(): ProductCollection
    {
        $productCollection = new ProductCollection();

        $serializer = new Serializer([], [new CsvEncoder()]);
        $productsData = $serializer->decode(file_get_contents(__DIR__ . "/ProductData.csv"), 'csv', ['no_headers']);

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

        $this->productImporter->update($productCollection);


        return $productCollection;
    }

}
