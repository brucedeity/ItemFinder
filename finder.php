<?php

require __DIR__ . '/vendor/autoload.php';

use App\ItemFinder;
use App\API\PW;

if (!isset($argv[1])) {
    echo 'Please provide an item id to search';
    exit;
}

$itemId = (int)$argv[1];

if (!is_int($itemId)) {
    echo 'Item id must be an integer';
    exit;
}

echo 'Starting the search for the item id: ' . $itemId . PHP_EOL;

$itemFinder = new ItemFinder($itemId);
$itemFinder->findItem();