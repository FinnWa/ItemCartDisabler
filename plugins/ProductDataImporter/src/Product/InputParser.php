<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

final class InputParser
{

    private EntityRepository $entityRepository;
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function parse(): ProductCollection
    {
        $productCollection = new ProductCollection();
        $productImporter = new ProductImporter($this->entityRepository, $this->parse());

        $product = null;

        if (($handle = fopen("ProductData.csv", 'rb')) !== false) {
            while (($productData = fgetcsv($handle, 1000, ",")) !== false) {
                $product = new Product();

                $product->addData($productData);

                $productCollection->add($product);
            }
            fclose($handle);

            $productImporter->update();
        }


        return $productCollection;
    }

}
