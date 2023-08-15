<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;

use ProductDataImporter\Product\ProductImport\ProductCollection;
use ProductDataImporter\Product\ProductMediaImport;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductImageDownloader
{
    public function download(ProductCollection $productCollection): ProductMediaImport\ProductImageCollection
    {
        $imageCollection = new ProductImageCollection();

        if (!is_dir(__DIR__ . '/MediaDownload')) {
            mkdir(__DIR__ . '/MediaDownload', 0777, true);
        }

        foreach ($productCollection as $product) {
            foreach ($product->productImageUrl as $singleImage) {
                $imageName = explode('/', $singleImage);

                $imageNameParts = explode('.', array_pop($imageName));
                $imageExtension = '.' . $imageNameParts[1];
                $imagePath = __DIR__ . '/MediaDownload/';

                $productImageName = $product->productName . Uuid::randomHex();


                file_put_contents($imagePath . $productImageName . $imageExtension,
                    file_get_contents($singleImage));

                $image = new ProductImage(Uuid::randomHex(), $productImageName, $imageExtension, $imagePath,
                    $product->id, $product->productNumber);
                $imageCollection->add($image);
            }
        }

        return $imageCollection;
    }
}
