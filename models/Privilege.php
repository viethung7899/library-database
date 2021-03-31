<?php

namespace app\models;

use app\core\Model;

class Privilege extends Model {
  public static function addPrevilege(int $id, string $password, int $level = 0) {
    $statement = self::getDatabase()->prepare('INSERT INTO privilege VALUES (:id, :password, :level)');
    $statement->execute([':id' => $id, ':password' => $password, ':level' => $level]);
  }

  public static function updatePassword(int $id, string $password) {
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $statement = self::getDatabase()->prepare('UPDATE privilege SET hash_password = :h WHERE user_id = :id');
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':h', $hashPassword);
    $statement->execute();
  }
}