<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Ramsey\Collection\AbstractCollection;
use Ramsey\Collection\CollectionInterface;
use Traversable;

/**
 * @extends AbstractCollection<Product>
 * @implements CollectionInterface<Product>
 */
final class ProductCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Product::class;
    }
}
