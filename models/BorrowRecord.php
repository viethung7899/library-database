<?php
namespace app\models;

use app\core\Model;

class BorrowRecord extends Model {
  public ?string $isbn = '';
  public ?string $user_id = NULL;
  public ?string $borrowDate = NULL;
  public ?string $pickupDate = NULL;

  public static function addBorrowRecord(string $user_id, string $isbn, date $borrowDate, date $pickup_date) {
    $statement = self::getDatabase()->prepare("INSERT INTO borrowRecord (user_id, isbn, borrowDate, pickupDate) VALUES (:id, :isbn, :borrowDate, :pickup)");
    $statement->bindValue(':id', $user_id);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':borrowDate', $borrowDate);
    $statement->bindValue(':pickup', $pickup_date);
    return $statement->execute();
  }
}
