<?php

require __DIR__.'/../vendor/autoload.php';

use App\ItemFinder;

if (isset($_GET['itemId'])) {
    $itemId = $_GET['itemId'];

    $itemFinder = new ItemFinder($itemId);
    $logFilePath = $itemFinder->findItem();
    
    // Render the search results using the log file
    renderSearchResults($logFilePath);
} else {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Missing itemId parameter'));
}

function renderSearchResults($logFilePath) {
    $json = file_get_contents($logFilePath);
    $logs = json_decode($json, true);

    $table = '<table>';
    $table .= '<tr><th>Role Name</th><th>Item</th><th>Type</th></tr>';

    foreach ($logs as $log) {
        $table .= '<tr>';
        $table .= '<td>' . htmlspecialchars($log['role']['name']) . ' ('.$log['role']['id'].')</td>';
        $table .= '<td class="item">x'.$log['count'].' <img src="https://www.pwdatabase.com/images/icons/generalm/' . $log['itemId'] . '.png"></td>';
        $table .= '<td>' . $log['type'] . '</td>';
        $table .= '</tr>';
    }

    $table .= '</table>';

    echo $table;
}
