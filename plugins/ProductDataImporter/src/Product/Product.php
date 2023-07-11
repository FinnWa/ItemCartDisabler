<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


//CHANGED DUE TO VALIDATION REMOVED READONLY
final class Product
{
    private const BRUTTO_PERCENT = 1.19;
    public float $productBruttoPrice;

    public function __construct(
        public string $productNumber,
        public string $productName,
        public string $productDescription,
        public float $productNettoPrice,
        float $productBruttoPrice,
        public string $productImageUrl,
        public string $id,
    ) {
        $this->productBruttoPrice = round(($productBruttoPrice * self::BRUTTO_PERCENT), 2);
    }
}
