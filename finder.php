<?php

require __DIR__ . '/vendor/autoload.php';

use App\ItemFinder;

if (!isset($argv[1])) {
    echo 'Please provide an item id to search, usage : php finder.php item_id'.PHP_EOL;
    exit;
}

$itemId = (int)$argv[1];

if (!is_int($itemId)) {
    echo 'Item id must be an integer'.PHP_EOL;
    exit;
}

echo 'Starting the search for the item id: ' . $itemId . PHP_EOL;

$itemFinder = new ItemFinder($itemId);
$itemFinder->findItem();