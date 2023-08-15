<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductMediaImport;

use Ramsey\Collection\AbstractCollection;
use Ramsey\Collection\CollectionInterface;

/**
 * @extends AbstractCollection<ProductMedia>
 * @implements CollectionInterface<ProductMedia>
 * @implements \IteratorAggregate<int,ProductMedia>
 */
final class ProductMediaCollection extends AbstractCollection
{
    public function getType(): string
    {
        return ProductMedia::class;
    }
}
