<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;


final class ProductMedia
{
    public function __construct(
        public string $id,
        public string $productId,
        public string $imageName,
        public string $productNumber
    ) {
    }

}
