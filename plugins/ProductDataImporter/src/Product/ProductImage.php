<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\Uuid\Uuid;

final class ProductImage
{
    public function __construct(
        public string $id,
        public string $imageName,
        public string $imageExtension,
        public string $imagePath,
        public string $productId
    ) {
    }

}
