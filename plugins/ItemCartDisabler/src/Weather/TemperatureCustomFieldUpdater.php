<?php

declare(strict_types=1);

namespace ItemCartDisabler\Weather;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class TemperatureCustomFieldUpdater
{
    private EntityRepository $entityRepository;
    private TemperatureDatabaseWriter $temperatureDatabaseWriter;

    public function __construct(EntityRepository $entityRepository, TemperatureDatabaseWriter $temperatureDatabaseWriter)
    {
        $this->entityRepository = $entityRepository;
        $this->temperatureDatabaseWriter = $temperatureDatabaseWriter;
    }

    public function update(string  $maxTemperature, string $minTemperature): void
    {
        $products = $this->entityRepository->search(new Criteria(), Context::createDefaultContext());

        foreach ($products as $product){
            $this->temperatureDatabaseWriter->write(
                $product,
                $maxTemperature,
                $minTemperature
            );
        }
        dump($products);
    }

}