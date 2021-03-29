<?php

namespace app\models;

use app\core\Model;

class Privilege extends Model {
  public static function addPrevilege(int $id, string $password, int $level = 0) {
    $statement = self::getDatabase()->prepare('INSERT INTO privilege VALUES (:id, :password, :level)');
    $statement->execute([':id' => $id, ':password' => $password, ':level' => $level]);
  }
}