<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use mysql_xdevapi\Collection;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

final class CsvWriter
{
    public function __construct(private Serializer $serializer)
    {
    }

    public function write($collection, string $path): void
    {
        $products = [];
        foreach ($collection as $product) {
            $products[] = [
                'NUMBER' => $product->productNumber,
                'NAME' => $product->productName,
                'DESCRIPTION' => $product->productDescription,
                'PRICE_NET' => $product->productNettoPrice,
                'IMAGE' => $product->productImageUrl,
            ];
        }

        file_put_contents(__DIR__ . $path,
            $this->serializer->encode($products, 'csv', [CsvEncoder::DELIMITER_KEY => ';']), FILE_APPEND );
    }
}
