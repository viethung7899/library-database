<?php

namespace app\core;

use app\utils\Dumpster;
use PDO;

class Database {
  public \PDO $pdo;

  // Create a database instance with specific configuration
  public function __construct(array $config) {
    $dsn = $config['dsn'] ?? '';
    $username = $config['username'] ?? '';
    $password = $config['password'] ?? '';
    $this->pdo = new PDO($dsn, $username, $password);
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  // Prepare the query before execution
  public function prepare(string $query) {
    return $this->pdo->prepare($query);
  }
}