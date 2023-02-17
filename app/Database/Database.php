<?php

namespace App\Database;

use Dotenv\Dotenv;
use PDO;

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;
  
    public function __construct() {
      $this->host = $this->getEnv('DB_HOST');
      $this->db = $this->getEnv('DB_NAME');
      $this->user = $this->getEnv('DB_USER');
      $this->pass = $this->getEnv('DB_PASS');
      $this->charset = 'utf8mb4';
  
      $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];
  
      try {
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
      } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
      }
    }

    private function getEnv($key) {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
      
        return $_ENV[$key];
    }
  
    public function getConnection() {
      return $this->pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT ID FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }


  }
  