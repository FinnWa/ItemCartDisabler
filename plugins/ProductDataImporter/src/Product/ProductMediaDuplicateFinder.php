<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


use Dompdf\Exception;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;


final class ProductMediaDuplicateFinder
{
    public function __construct(private EntityRepository $mediaRepository, private ProductSearcher $productSearcher)
    {
    }

    public function find(ProductImage $image): bool
    {
        $product = $this->productSearcher->search($image);
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('productId', $product->getId()));
        $media = $this->mediaRepository->search($criteria, Context::createDefaultContext())->first();

        return ($media !== null) && $image->imageName === $media->getMedia()->getFileName();
    }
}
