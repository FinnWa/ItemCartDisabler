<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductSearch;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

final class ProductSearcher
{

    public function __construct(private EntityRepository $entityRepository)
    {
    }

    public function search($product): ?ProductEntity
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productNumber', $product->productNumber));
        return $this->entityRepository->search($criteria, Context::createDefaultContext())->first();
    }

}
