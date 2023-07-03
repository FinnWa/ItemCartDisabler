<?php

declare(strict_types=1);

namespace ProductDataImporter\Product\Command;

use ProductDataImporter\Product\InputParser;
use ProductDataImporter\Product\ProductImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
final class ImportProducts extends Command
{
    private ProductImporter $productImporter;
    private InputParser $inputParser;

    public function __construct(InputParser $inputParser)
    {
        $this->inputParser = $inputParser;
        parent::__construct();
    }

    protected static $defaultName = 'productImporter:add';

    protected function configure(): void
    {
        $this->setDescription('add new products');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->inputParser->parse();

        $output->writeln('products added');

        return 0;
    }
}
