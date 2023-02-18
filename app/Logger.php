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
        $this->logContent = [];
    }

    public function setRole(array $role)
    {
        $this->role = $role;
    }

    public function logBag(array $item)
    {
        $logEntry = [
            'type' => 'bag',
            'count' => $item['count'],
            'itemId' => $item['id'],
            'role' => [
                'name' => $this->role['name'],
                'id' => $this->role['id']
            ]
        ];
        array_push($this->logContent, $logEntry);
    }
    
    public function logStorehouse(array $item)
    {
        $logEntry = [
            'type' => 'storehouse',
            'count' => $item['count'],
            'itemId' => $item['id'],
            'role' => [
                'name' => $this->role['name'],
                'id' => $this->role['id']
            ]
        ];
        array_push($this->logContent, $logEntry);
    }
    

    public function saveLog()
    {
        $json = json_encode($this->logContent, JSON_PRETTY_PRINT);
        $fp = fopen($this->logFilePath, 'w');
        fwrite($fp, $json);
        fclose($fp);
    }
}