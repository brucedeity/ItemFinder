<?php

require __DIR__ . '/vendor/autoload.php';

use Src\ItemFinder;
use Src\API\PW;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

echo 'Starting the search for the item id: '. $argv[1]. PHP_EOL;

$itemFinder = new ItemFinder($argv[1]);
$itemFinder->findItem();
