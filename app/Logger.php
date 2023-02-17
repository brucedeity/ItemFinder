<?php

namespace App;
class Logger
{
    private $logFilePath;
    private $logContent;
    private $role;

    public function __construct()
    {
        $this->logFilePath = dirname(__DIR__) . '/logs/search ' . date('Y-m-d h-i-s') . '.log';
        $this->logContent = "";
    }

    public function setRole(array $role)
    {
        $this->role = $role;
    }

    public function logBag(array $item)
    {
        $logEntry = "[Bag] found {$item['count']} units of the item id {$item['id']} for the role {$this->role['name']} id: {$this->role['id']} \n";
        $this->logContent .= $logEntry;
    }

    public function logStorehouse(array $item)
    {
        $logEntry = "[Storehouse] found {$item['count']} units of the item id {$item['id']} for the role {$this->role['name']} id: {$this->role['id']} \n";
        $this->logContent .= $logEntry;
    }

    public function saveLog()
    {
        $fp = fopen($this->logFilePath, 'w');
        fwrite($fp, $this->logContent);
        fclose($fp);
    }
}