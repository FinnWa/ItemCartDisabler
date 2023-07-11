<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\File\MediaFile;
use Shopware\Core\Content\Media\MediaCollection;
use Shopware\Core\Content\Media\MediaService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductImageToMedia
{

    public function __construct(
        private ProductImageDownloader $productImageDownloader,
        private FileSaver $fileSaver,
        private MediaService $mediaService,
        private ProductMediaImporter $mediaImporter
    ) {
    }

    public function add(ProductCollection $productCollection): string
    {
        $mediaCollection = new ProductMediaCollection();
        $imageCollection = $this->productImageDownloader->download($productCollection);

        foreach ($imageCollection as $image) {
            $filePath = $image->imagePath . $image->imageName . $image->imageExtension;

            $mediaFile = new MediaFile($filePath, mime_content_type($filePath), ltrim($image->imageExtension, '.'),
                filesize($filePath));

            $mediaId = $this->mediaService->createMediaInFolder('product', Context::createDefaultContext(),
                false);

            $this->fileSaver->persistFileToMedia($mediaFile, $image->imageName, $mediaId,
                Context::createDefaultContext());

            $productMedia = new ProductMedia($mediaId, $image->productId, $image->imageName);
            $mediaCollection->add($productMedia);
        }

        $this->mediaImporter->import($mediaCollection);
        return $mediaId;
    }
        //mapping keinen guten Weg gefunden
}
