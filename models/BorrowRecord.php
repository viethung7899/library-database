<?php

namespace app\models;

use app\core\Model;

class BorrowRecord extends Model
{
  public ?string $isbn = '';
  public ?string $user_id = NULL;
  public ?string $borrowDate = NULL;
  public ?string $pickupDate = NULL;

  public static function addBorrowRecord(string $user_id, string $isbn, date $borrowDate, date $pickup_date)
  {
    $statement = self::getDatabase()->prepare("INSERT INTO borrowRecord (user_id, isbn, borrowDate, pickupDate) VALUES (:id, :isbn, :borrowDate, :pickup)");
    $statement->bindValue(':id', $user_id);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':borrowDate', $borrowDate);
    $statement->bindValue(':pickup', $pickup_date);
    return $statement->execute();
  }

  public static function deleteBorrowRecord(string $user_id, string $isbn)
  {
    $statement = self::getDatabase()->prepare("DELETE FROM borrowRecord WHERE user_id = :id AND isbn = :isbn)");
    $statement->bindValue(':id', $user_id);
    $statement->bindValue(':isbn', $isbn);
    return $statement->execute();
  }

  public static function getBorrowRecord(BorrowRecord $record)
  {
    $query = 'SELECT bv.isbn, bv.title, r.user_id, r.`pickupDate`, r.`borrowDate` FROM book_view bv 
        JOIN record r 
        ON r.isbn = bv.isbn AND bv.isbn LIKE :isbn AND bv.title LIKE :title
        JOIN user u
        ON u.user_id = r.user_id AND u.name LIKE :name';

    if (isset($record->user_id) && !empty($record->user_id)) {
      $query = $query . ' AND u.user_id = :id';
    }

    $statement = self::getDatabase()->prepare($query);
    $statement->bindValue(':isbn', '%' . $record->isbn . '%');
    $statement->bindValue(':title', '%' . $record->title . '%');
    $statement->bindValue(':name', '%' . $record->name . '%');

    if (isset($record->user_id) && !empty($record->user_id)) {
      $statement->bindValue(':name', $record->id, \PDO::PARAM_INT);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
  }
}
