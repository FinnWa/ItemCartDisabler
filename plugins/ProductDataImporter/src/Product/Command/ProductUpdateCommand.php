<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\Command;

use ProductDataImporter\Product\InputParser;
use ProductDataImporter\Product\ProductUpdater\ProductDataUpdater;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('product:update', 'updates products')]
final class ProductUpdateCommand extends Command
{

    public function __construct(private InputParser $inputParser, private ProductDataUpdater $productDataUpdater)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'path to file location');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->inputParser->parse($input->getArgument('path'));

        $this->productDataUpdater->update($products);

        $output->writeln('products updated');

        return self::SUCCESS;
    }
}
