<?php

require __DIR__.'/../vendor/autoload.php';

use App\ItemFinder;

if (isset($_GET['itemId'])) {
    $itemId = $_GET['itemId'];

    $itemFinder = new ItemFinder($itemId);
    $result = $itemFinder->findItem();

    
} else {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Missing itemId parameter'));
}
