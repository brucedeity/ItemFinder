<?php

namespace App;

use Src\Database\Database;
use Src\PWApi\PWApi;

class ItemFinder
{
    public function findItem(int $itemId)
    {
        $database = new Database();

        $users = $database->getAllUsers();

        foreach ($users as $user) {
            // PWApi::
        }
    }
}
