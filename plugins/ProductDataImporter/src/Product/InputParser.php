<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Shopware\Core\Content\Media\File\FileSaver;
use Shopware\Core\Content\Media\MediaService;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class InputParser
{
    public function __construct(private Serializer $serializer, private ProductImageToMedia $imageToMedia)
    {
    }

    public function parse(string $path): ProductCollection
    {
        $productCollection = new ProductCollection();

        $productsData = $this->serializer->decode(file_get_contents($path), CsvEncoder::FORMAT, ['no_headers']);

        foreach ($productsData as $productData) {
            $product = new Product(
                (string)$productData['NUMBER'],
                $productData['NAME'],
                $productData['DESCRIPTION'],
                (float)$productData['PRICE_NET'],
                (float)$productData['PRICE_NET'],
                (string)$productData['IMAGE']
            );
            $productCollection->add($product);
        }
        $this->imageToMedia->convert($productCollection);
        return $productCollection;
    }

}
