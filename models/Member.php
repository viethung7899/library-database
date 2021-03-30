<?php
namespace app\models;

class Member extends User {
  public function register() {
    $response = parent::register();
    if ($response->ok()) {
      // Add to the privilege
      $hash = password_hash($this->password, PASSWORD_DEFAULT);
      Privilege::addPrevilege($this->user_id, $hash);

      // Add to the member table
      self::addMember($this->user_id);
    }

    return $response;
  }

  // Static method for interating with Member table
  public static function addMember(int $id, int $period = 1) {
    $statement = self::getDatabase()->prepare("INSERT INTO member (member_id, period) VALUES (:id, :period)");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    $statement->bindValue(':period', $period, \PDO::PARAM_INT);
    return $statement->execute();
  }
}