<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductSearch;

use ProductDataImporter\Product\ProductImport\Product;
use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

final readonly class ProductMediaSearcher
{
    public function __construct(private EntityRepository $entityRepository)
    {
    }

    public function search(Product $product): ?array
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productNumber', $product->productNumber));
        $criteria->addAssociation('media');

        /** @var ProductEntity $product */
        $product = $this->entityRepository->search($criteria, Context::createDefaultContext())->first();
        /** @var MediaEntity $media */
        $media = $product->getMedia();

        return $media->getIds();
    }
}
