<?php

namespace app\models;

use app\core\Model;

class Publisher extends Model {
  // Find the id of publisher
  public static function findPublisherId(string $name) {
    $getId = self::getDatabase()->prepare("SELECT id FROM publisher WHERE publisher_name = :n");
    $getId->bindValue(':n', $name);
    $getId->execute();
    return $getId->fetchColumn();
  }

  // Return the id of exisiting publisher id or newly inserted publisher
  public static function addPublisher(Book $book) {
    $exisitingId = self::findPublisherId($book->publisher_name);
    if ($exisitingId) return $exisitingId;
    $query = self::getDatabase()->prepare("INSERT INTO publisher publisher_name VALUES :n");
    $query->bindValue(':n', $book->publisher_name);
    $query->execute();
    return self::getDatabase()->pdo->lastInsertId();
  }
}
