<?php
namespace app\models;

class Member extends User {
  public static function register($data) {
    $response = parent::register($data);
    if ($response->ok()) {
      $id = $response->content['id'];
      // Add to the privilege
      $hash = password_hash($data['password'], PASSWORD_DEFAULT);
      Privilege::addPrevilege($id, $hash);

      // Add to the member table
      self::addMember($id);
    }

    return $response;
  }

  public static function addMember(int $id, int $period = 1) {
    $statement = self::getDatabase()->prepare("INSERT INTO member (member_id, period) VALUES (:id, :period)");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':period', $period, \PDO::PARAM_INT);
    return $statement->execute();
  }
}