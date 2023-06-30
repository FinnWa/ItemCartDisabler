<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

use Traversable;

final class ProductCollection implements \IteratorAggregate
{
    /** @var array<Product> */
    private array $products = [];

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    public function products(): array
    {
        return $this->products;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->products);
    }
}
