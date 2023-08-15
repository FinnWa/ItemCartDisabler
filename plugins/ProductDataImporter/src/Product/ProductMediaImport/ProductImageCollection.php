<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;

use Ramsey\Collection\AbstractCollection;
use Ramsey\Collection\CollectionInterface;

/**
 * @extends AbstractCollection<ProductImage>
 * @implements CollectionInterface<ProductImage>
 * @implements \IteratorAggregate<int,ProductImage>
 */
final class ProductImageCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ProductImage::class;
    }
}
