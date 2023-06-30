<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

final class InputParser
{

    public function parse(): ProductCollection
    {
        $productCollection = new ProductCollection();

        $product = null;

        if (($handle = fopen("ProductData.csv", 'rb')) !== false) {
            while (($productData = fgetcsv($handle, 1000, ",")) !== false) {
                $product = new Product();

                $product->addData($productData);

                $productCollection->add($product);
            }
            fclose($handle);
        }


        return $productCollection;
    }

}
