<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\Command;

use ProductDataImporter\Product\InputParser;
use ProductDataImporter\Product\ProductDataDeleter;
use ProductDataImporter\Product\ProductImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('product:delete', 'deletes products')]
final class ProductDeleteCommand extends Command
{

    public function __construct(private InputParser $inputParser, private ProductDataDeleter $productDataDeleter)
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

        $this->productDataDeleter->delete($products);

        $output->writeln('products deleted');

        return self::SUCCESS;
    }
}
