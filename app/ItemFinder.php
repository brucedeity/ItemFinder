<?php

namespace App;

use App\Database\Database;
use App\API\PW;
use App\Logger;

class ItemFinder
{
    private $itemId;

    private $logger;
    private $foundItems;

    public function __construct(int $itemId)
    {   
        $this->itemId = $itemId;

        $this->foundItems = 0;
    }

    public function findItem()
    {
        $database = new Database();
        $users = $database->getAllUsers();

        echo 'found '. count($users). ' users accounts in database'.PHP_EOL;

        echo 'this may take a while.. please wait!'.PHP_EOL;

        $pwapi = new PW;

        $searchedRoles = 0;

        $this->logger = new Logger();

        foreach ($users as $user) {

            $roles = $pwapi->getRoles($user['ID']);

            if (empty($roles)) continue;

            foreach ($roles['roles'] as $role) {

                $searchedRoles++;

                $roleInfo = $pwapi->getRole($role['id']);

                if (!is_array($roleInfo) OR !array_key_exists('base', $roleInfo)) {
                    // echo 'the role '. $role['name'] .', id: '. $role['id']. ' is not valid, skipping it.'.PHP_EOL;

                    continue;
                }

                $this->logger->setRole($role);

                $this->searchRoleBag($roleInfo);

                $this->searchRoleStoreHouse($roleInfo);
            }
        }

        $this->logger->saveLog();

        echo 'searched roles: '.$searchedRoles. PHP_EOL;

        echo 'total amount of items found: '.$this->foundItems.PHP_EOL;
    }

    public function searchRoleBag(array $roleInfo)
    {
        if (!array_key_exists('inv', $roleInfo['pocket'])) return;

        foreach ($roleInfo['pocket']['inv'] as $item) {
            if ($item['id'] == $this->itemId) {

                $this->foundItems += $item['count'];

                $this->logger->logBag($item);

                if (php_sapi_name() === 'cli') {
                    echo 'found '.$item['count'].' item(s) of id '.$this->itemId.' in the bag of role '.$roleInfo['base']['name'].' id: '.$roleInfo['base']['id'].PHP_EOL;
                }

                return $item;
            }
        }

        return [];
    }

    public function searchRoleStoreHouse(array $roleInfo)
    {
        if (!array_key_exists('store', $roleInfo['storehouse'])) return;

        foreach ($roleInfo['storehouse']['store'] as $item) {
            if ($item['id'] == $this->itemId) {

                $this->foundItems += $item['count'];

                $this->logger->logStorehouse($item);

                if (php_sapi_name() === 'cli') {
                    echo 'found '.$item['count'].' item(s) of id '.$this->itemId.' in the storehouse of role '.$roleInfo['base']['name'].' id: '.$roleInfo['base']['id'].PHP_EOL;
                }

                return $item;
            }
        }

        return [];
    }
}
