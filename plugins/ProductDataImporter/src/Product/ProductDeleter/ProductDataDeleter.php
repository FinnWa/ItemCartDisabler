<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\ProductDeleter;


use ProductDataImporter\Product\ProductImport\ProductCollection;
use ProductDataImporter\Product\ProductSearch\ProductMediaSearcher;
use ProductDataImporter\Product\ProductSearch\ProductSearcher;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

final class ProductDataDeleter
{

    public function __construct(
        private readonly EntityRepository $entityRepository,
        private readonly ProductSearcher $productSearcher,
        private readonly EntityRepository $mediaRepository,
        private readonly ProductMediaSearcher $mediaSearcher,
    ) {
    }

    public function delete(ProductCollection $productCollection): void
    {
        foreach ($productCollection as $product) {
            $searchedProduct = $this->productSearcher->search($product);
            $searchedProductMediaIds = $this->mediaSearcher->search($product);

            if ($searchedProduct !== null) {
                $data = [
                    'id' => $searchedProduct->getId(),
                ];

                foreach ($searchedProductMediaIds as $searchedProductMediaId) {
                    $mediaData = [
                        'id' => $searchedProductMediaId
                    ];

                    $this->mediaRepository->delete([$mediaData], Context::createDefaultContext());
                }
                $this->entityRepository->delete([$data], Context::createDefaultContext());
            }
        }
    }

}
