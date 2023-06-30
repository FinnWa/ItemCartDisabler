<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

final class Product
{
    private ?int $productNumber = null;
    private ?string $productName = null;
    private ?string $productDescription = null;
    private ?float $productNettoPrice = null;
    private ?float $productBruttoPrice = null;

    const BRUTTO_PERCENT = 1.19;

    public function addData(array $productData): void
    {
            $this->productNumber = (int)$productData[0];
            $this->productName = $productData[1];
            $this->productDescription = $productData[2];
            $this->productNettoPrice = (float)$productData[3];
            $this->productBruttoPrice = (float)$productData[3] * self::BRUTTO_PERCENT;
    }

    public function getProductNumber(): ?int
    {
        return $this->productNumber;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function getProductNettoPrice(): ?float
    {
        return $this->productNettoPrice;
    }

    public function getProductBruttoPrice(): ?float
    {
        return $this->productBruttoPrice;
    }

}
