<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductMediaImporter
{

    public function __construct(
        private EntityRepository $mediaRepository,
        private EntityRepository $entityRepository
    ) {
    }

    public function import(ProductMediaCollection $mediaCollection): void
    {

        foreach ($mediaCollection as $media){
            $id = Uuid::randomHex();
        $data = ['id' => $id, 'productId' => $media->productId, 'mediaId' => $media->id];
        $this->mediaRepository->create([$data], Context::createDefaultContext());

        //$this->entityRepository->searchIds(new Criteria($media->productId), Context::createDefaultContext());
        }
    }
}
