<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Framework\Context;

final class ProductImageToMedia
{

   public function __construct(private ProductImageDownloader $productImageDownloader)
   {
   }

    public function convert(ProductCollection $productCollection): void
    {
        $this->productImageDownloader->download($productCollection);
        foreach ($productCollection as $product){

            $fileExtension = array_pop($product->productName, '.');
        $productMedia = new ProductMedia($filePath,$product->productName, $product->, Context::createDefaultContext());

        }

    }

}
