<?php

namespace app\models;

use app\core\Model;

class FinePayment extends Model {
  public ?int $user_id;
  public ?float $amount;

  public static function findFineById(int $userId) {
    $statement = self::getDatabase()->prepare('SELECT * FROM fine WHERE user_id = :u');
    $statement->bindValue(':u', $userId, \PDO::PARAM_INT);
    return $statement->fetchAll(\PDO::FETCH_CLASS, FinePayment::class);
  }

  // Make sure that payment is found
  public static function addPayment(int $userId, float $amount, string $method) {
    $statement = self::getDatabase()->prepare('INSERT INTO payment (user_id, paid_amount, method) VALUES (:u, :a, :m)');
    $statement->bindValue(':u', $userId, \PDO::PARAM_INT);
    $statement->bindValue(':a', $amount);
    $statement->bindValue(':u', $userId);
    $statement->execute();
  }

  public static function addFine(int $userId, int $amount) {
    $statement = self::getDatabase()->prepare('INSERT INTO fine (user_id, amount) VALUES (:u, :a) ON DUPLICATE KEY UPDATE amount = amount + :a');
    $statement->bindValue(':u', $userId, \PDO::PARAM_INT);
    $statement->bindValue(':a', $amount);
    $statement->execute();
  }

  public static function deleteFine(int $userId) {
    $statement = self::getDatabase()->prepare('DELETE FROM fine WHERE user_id = :u');
    $statement->bindValue(':u', $userId, \PDO::PARAM_INT);
    $statement->execute();
  }
}