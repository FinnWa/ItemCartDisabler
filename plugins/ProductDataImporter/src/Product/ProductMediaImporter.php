<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductMediaImporter
{

    public function __construct(
        private EntityRepository $mediaRepository,
    ) {
    }

    public function import(ProductMediaCollection $mediaCollection): void
    {
        var_dump($mediaCollection);
        foreach ($mediaCollection as $media){
            $id = Uuid::randomHex();
            var_dump("Das ist die ID:" . $id);
            var_dump($media);

        $data = ['id' => $id, 'productId' => $media->productId, 'mediaId' => $media->id];
        $this->mediaRepository->create([$data], Context::createDefaultContext());
        }
    }
}
