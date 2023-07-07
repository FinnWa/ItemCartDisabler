<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Content\Media\MediaService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;

final class ProductMediaImporter
{

    public function __construct(
        EntityRepository $mediaRepository,
        MediaService $mediaService,
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->mediaService = $mediaService;
    }

    public function create($productId, $mediaId): void
    {

        $data = ['productId' => $productId, 'mediaId' => $mediaId];
        $this->mediaRepository->create($data,  Context::createDefaultContext());
    }
}
