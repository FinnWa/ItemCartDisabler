<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;

final class ProductImage
{
    public function __construct(
        public string $id,
        public string $imageName,
        public string $imageExtension,
        public string $imagePath,
        public string $productId,
        public string $productNumber
    ) {
    }

}
