<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductImport;

use Ramsey\Collection\AbstractCollection;
use Ramsey\Collection\CollectionInterface;

/**
 * @extends AbstractCollection<Product>
 * @implements CollectionInterface<Product>
 * @implements \IteratorAggregate<int,Product>
 */
final class ProductCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Product::class;
    }
}
