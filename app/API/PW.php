<?php

namespace App\API;

use Dotenv\Dotenv;
use App\API\Gamed;
use App\API\Structure;

class PW
{
    public $online;
    public $data = [];
    public $gamed;
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->gamed = new Gamed();

        $this->data = Structure::getStructure($_ENV['SERVER_VERSION']);
    }

    public function getRole($roleId)
    {
        if ($_ENV['SERVER_VERSION'] == '7') {
            $role['base'] = $this->getRoleBase($roleId);
            $role['status'] = $this->getRoleStatus($roleId);
            $role['pocket'] = $this->getRoleInventory($roleId);
            //$role['pets'] = $this->getRolePetBadge($roleId);
            $role['equipment'] = $this->getRoleEquipment($roleId);
            $role['storehouse'] = $this->getRoleStoreHouse($roleId);
            // $role['task'] = $this->getRoleTask($roleId);
        } else {
            $pack = pack("N*", -1, $roleId);
            $pack = $this->gamed->createHeader($this->data['code']['getRole'], $pack);
            $send = $this->gamed->SendToGamedBD($pack);
            $data = $this->gamed->deleteHeader($send);
            $role = $this->gamed->unmarshal($data, $this->data['role']);
            if (!$role OR !is_array($role)) {

                $role = [];

                // $role['base'] = $this->getRoleBase($roleId);
                // $role['status'] = $this->getRoleStatus($roleId);
                $role['pocket'] = $this->getRoleInventory($roleId);
                // $role['pets'] = $this->getRolePetBadge($roleId);
                // $role['equipment'] = $this->getRoleEquipment($roleId);
                $role['storehouse'] = $this->getRoleStoreHouse($roleId);
                // $role['task'] = $this->getRoleTask($roleId);
            }
        }
        return $role;
    }

    public function getRoleName($roleId)
    {
        $roleBase = $this->getRoleBase($roleId);

        return $roleBase['name'];
    }

    public function getRoleBase($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader($this->data['code']['getRoleBase'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $user = $this->gamed->unmarshal($data, $this->data['role']['base']);
        return $user;
    }
    public function getRoleStatus($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader($this->data['code']['getRoleStatus'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $user = $this->gamed->unmarshal($data, $this->data['role']['status']);
        return $user;
    }
    public function getRoleInventory($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader($this->data['code']['getRoleInventory'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $user = $this->gamed->unmarshal($data, $this->data['role']['pocket']);
        return $user;
    }
    public function getRoleEquipment($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader($this->data['code']['getRoleEquipment'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $user = $this->gamed->unmarshal($data, $this->data['role']['equipment']);
        return $user;
    }
    public function getRolePetBadge($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader(3088, $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $user = $this->gamed->unmarshal($data, $this->data['role']['pocket']['petbadge']);
        return $user;
    }
    public function getRoleStorehouse($role)
    {
        $pack = pack("N*", -1, $role);
        $pack = $this->gamed->createHeader($this->data['code']['getRoleStoreHouse'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $store = $this->gamed->unmarshal($data, $this->data['role']['storehouse']);
        return $store;
    }
    
    public function getRoles($userID)
    {
        $pack = pack("N*", -1, $userID);
        $pack = $this->gamed->createHeader($this->data['code']['getUserRoles'], $pack);
        $send = $this->gamed->SendToGamedBD($pack);
        $data = $this->gamed->deleteHeader($send);
        $roles = $this->gamed->unmarshal($data, $this->data['user']['roles']);
        return $roles;
    }
}