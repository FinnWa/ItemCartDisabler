<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductImport;


//CHANGED DUE TO VALIDATION REMOVED READONLY
final readonly class Product
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

    public function hasImage(): bool
    {
        return $this->productImageUrl !== '';
    }

    public function hasProductNumber(): bool
    {
        return $this->productNumber !== '';
    }

    public function hasProductName(): bool
    {
        return $this->productName !== '';
    }
}
