<?php

require __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Src\ItemFinder;
use Src\API\PW;

$pwapi = new PW;

print_r($pwapi->getRole(1024));

die();

$itemFinder = new ItemFinder($argv[1]);