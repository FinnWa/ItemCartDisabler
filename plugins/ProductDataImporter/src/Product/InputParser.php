<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


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

        if (($handle = fopen(__DIR__ . "/ProductData.csv", 'rb')) !== false) {
            while (($productData = fgetcsv($handle, 1000, ",")) !== false) {

                $product = new Product(
                    (string)$productData[0],
                    $productData[1],
                    $productData[2],
                    (float)$productData[3],
                    (float)$productData[3]
                );

                $productCollection->add($product);
            }
            fclose($handle);

            $this->productImporter->update($productCollection);
        }


        return $productCollection;
    }

}
