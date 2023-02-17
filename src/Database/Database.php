<?php

namespace Src\Database;

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
      $dotenv = Dotenv::createImmutable(__DIR__);
      $dotenv->load();
  
      $this->host = $_ENV['DB_HOST'];
      $this->db = $_ENV['DB_NAME'];
      $this->user = $_ENV['DB_USER'];
      $this->pass = $_ENV['DB_PASS'];
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
  
    public function getConnection() {
      return $this->pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare("SELECT ID FROM users");
        $stmt->execute();
        return $stmt->fetch();
    }


  }
  