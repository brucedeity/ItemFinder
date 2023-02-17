<?php

namespace Src;

use Src\Database\Database;
use Src\API\PW;

class ItemFinder
{
    private $itemId;

    public function __construct(int $itemId)
    {   
        $this->itemId = $itemId;
    }

    public function findItem()
    {
        $database = new Database();
        $users = $database->getAllUsers();

        $inventoryItems = [];

        $storeHouseItems = [];

        $pwapi = new PW;

        foreach ($users as $user) {
            $roles = $pwapi->getRoles($user['ID']);

            if (empty($roles)) continue;

            foreach ($roles['roles'] as $key => $value) {
                $role = $pwapi->getRole($key);

                if (!is_array($role)) continue;

                $inventoryItems = $this->searchRoleBag($role);

                $storeHouseItems = $this->searchRoleStoreHouse($role);
            }
        }

        return [
            'storehouse' => $storeHouseItems,
            'inventory' => $inventoryItems
        ];
    }

    public function searchRoleBag(array $role)
    {
        if (!array_key_exists('inv', $role['pocket'])) return;

        foreach ($role['pocket']['inv'] as $item) {
            if ($item['id'] == $this->itemId) return $item;
        }

        return [];
    }

    public function searchRoleStoreHouse(array $role)
    {
        if (!array_key_exists('store', $role['storehouse'])) return;

        foreach ($role['storehouse']['store'] as $item) {
            if ($item['id'] == $this->itemId) return $item;
        }

        return [];
    }
}
