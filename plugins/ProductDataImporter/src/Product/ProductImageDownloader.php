<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use ProductDataImporter\Product\ProductImageCollection;
use Shopware\Core\Framework\Uuid\Uuid;

final class ProductImageDownloader
{
    public function download(ProductCollection $productCollection): \ProductDataImporter\Product\ProductImageCollection
    {
        $imageCollection = new ProductImageCollection();

        if (!is_dir(__DIR__ . '/MediaDownload')) {
            mkdir(__DIR__ . '/MediaDownload', 0777, true);
        }

        foreach ($productCollection as $product) {

            $imageName = explode('/', $product->productImageUrl);
            $imageNameParts = explode('.', array_pop($imageName));
            $imageExtension = '.' . $imageNameParts[1];
            $imagePath = __DIR__ . '/MediaDownload/';


            file_put_contents($imagePath . $product->productName . $imageExtension,
                file_get_contents($product->productImageUrl));

            $image = new ProductImage(Uuid::randomHex(), $product->productName, $imageExtension, $imagePath, $product->id);
            $imageCollection->add($image);
        }
        return  $imageCollection;
    }
}
