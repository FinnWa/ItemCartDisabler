<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;


use ProductDataImporter\Product\ProductSearch\ProductSearcher;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductMediaImporter
{

    public function __construct(
        private EntityRepository $mediaRepository,
        private EntityRepository $entityRepository,
        private ProductSearcher $productSearcher
    ) {
    }

    public function import(ProductMediaCollection $mediaCollection): void
    {

        foreach ($mediaCollection as $media) {

            $id = Uuid::randomHex();
            $data = ['id' => $id, 'productId' => $media->productId, 'mediaId' => $media->id];

            $this->mediaRepository->create([$data], Context::createDefaultContext());

            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('id', $media->productId));

            $product = $this->entityRepository->search($criteria, Context::createDefaultContext())->first();

            if (!$product->getCoverId()){
                $this->entityRepository->update([
                    [
                        'id' => $media->productId,
                        'coverId' => $data['id']
                    ]
                ], Context::createDefaultContext());
            }
        }
    }
}
