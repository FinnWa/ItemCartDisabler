<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

final class ProductMediaSearcher
{
    public function __construct(private EntityRepository $entityRepository, private ProductSearcher $productSearcher)
    {
    }

    public function search(Product $product): ?MediaEntity
    {
        $product = $this->productSearcher->search($product);
        dd($product);
    }
}
