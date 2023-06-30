<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

final class ProductImporter
{
    private EntityRepository $entityRepository;
    private ProductCollection $productCollection;

    public function __construct(EntityRepository $entityRepository, ProductCollection $productCollection)
    {
        $this->entityRepository = $entityRepository;
        $this->productCollection = $productCollection;
    }

    public function update(): void
    {
        echo "hello";
        $productCollection = $this->productCollection->products();
        $products = $this->entityRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($productCollection as $product){
            var_dump($product);
            //$this->entityRepository->create($product, Context::createDefaultContext());
        }
    }
}
