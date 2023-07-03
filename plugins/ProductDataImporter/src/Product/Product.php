<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

final class Product
{


    const BRUTTO_PERCENT = 1.19;

    public function __construct(
        string $productNumber,
        string $productName,
        string $productDescription,
        float $productNettoPrice,
        float $productBruttoPrice
    ) {
        $this->productNumber = $productNumber;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productNettoPrice = $productNettoPrice;
        $this->productBruttoPrice = round(($productBruttoPrice * self::BRUTTO_PERCENT), 2);
    }

    public function getProductNumber(): ?string
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
