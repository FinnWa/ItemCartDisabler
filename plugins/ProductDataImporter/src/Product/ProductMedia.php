<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Shopware\Core\Framework\Context;

final class ProductMedia
{
    public function __construct(
        public string $id,
        public string $productId,
        public string $imageName
    ) {
    }

}
