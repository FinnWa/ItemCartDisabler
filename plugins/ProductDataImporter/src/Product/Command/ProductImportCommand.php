<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\Command;

use ProductDataImporter\Product\InputParser;
use ProductDataImporter\Product\ProductImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('product:import', 'add new products')]
final class ProductImportCommand extends Command
{

    public function __construct(private InputParser $inputParser, private ProductImporter $productImporter)
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

        $this->productImporter->update($products);

        $output->writeln('products added');

        return self::SUCCESS;
    }
}
