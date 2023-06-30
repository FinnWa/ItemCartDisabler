<?php

declare(strict_types=1);

namespace ProductDataImporter\Product;

require_once __DIR__.'/InputParser.php';
require_once __DIR__.'/Product.php';
require_once __DIR__.'/ProductCollection.php';
$inputParser = new InputParser();

var_dump($inputParser->parse());
