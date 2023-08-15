<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\DuplicateFinder;

final class DuplicatedProduct
{
    private const BRUTTO_PERCENT = 1.19;
    public float $productBruttoPrice;

    public function __construct(
        public ?string $productNumber,
        public ?string $productName,
        public ?string $productDescription,
        public ?float $productNettoPrice,
        ?float $productBruttoPrice,
        public ?string $productImageUrl,
    ) {
        $this->productBruttoPrice = round(($productBruttoPrice * self::BRUTTO_PERCENT), 2);
    }
}
