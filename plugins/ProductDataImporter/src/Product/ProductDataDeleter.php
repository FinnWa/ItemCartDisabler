<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;


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
            $searchedProductMedia = $this->mediaSearcher->search($product);
            dd($searchedProductMedia);
            if ($searchedProduct !== null) {
                $data = [
                    'id' => $searchedProduct->getId(),
                ];
                if ($searchedProduct->getMedia()->getIds() !== null) {
                    $this->mediaRepository->delete([['id' => $searchedProduct->getMedia()->getMediaIds()]],
                        Context::createDefaultContext());
                }
                $this->entityRepository->delete([$data], Context::createDefaultContext());
            }
        }
    }

}
