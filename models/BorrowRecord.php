<?php

namespace app\models;

use app\core\Model;
use app\utils\Dumpster;
use app\utils\Rule;

class BorrowRecord extends Model {
  public ?int $id = NULL;
  public ?string $isbn = '';
  public ?string $user_id = NULL;
  public ?string $borrowDate = NULL;
  public ?string $returnDate = NULL;
  public ?string $title = '';
  public ?string $name = '';

  public ?string $before = '';
  public ?string $after = '';

  public function __construct(bool $loading = false) {
    if ($loading) $this->loadDataFromRequest();
  }

  protected static function rules() {
    return [
      'isbn' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'user_id' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'returnDate' => [[Rule::REQUIRED]]
    ];
  }

  public function add() {
    $response = $this->verifyInput();

    // Failed validation
    if (!$response->ok()) return $response;

    // Find user
    $user = User::findOneById($this->user_id);
    if (empty($user)) {
      $response->addError('user_id', 'User not found');
      return $response;
    }

    // Find books
    $book = Book::getBookByISBN($this->isbn);
    if (empty($book)) {
      $response->addError('isbn', 'Book not found');
      return $response;
    }

    // Count books
    $count = Book::countAvailableBooks($this->isbn);
    if (!$count || $count == 0) {
      $response->addError('isbn', 'No more books');
      return $response;
    }

    self::addBorrowRecord($this->user_id, $this->isbn, $this->returnDate);
    return $response;
  }

  public static function addBorrowRecord(string $user_id, string $isbn, string $returnDate) {
    $statement = self::getDatabase()->prepare("INSERT INTO borrow_record (user_id, isbn, `returnDate`) VALUES (:id, :isbn, :returnDate)");
    $statement->bindValue(':id', $user_id);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':returnDate', $returnDate);
    return $statement->execute();
  }

  public static function deleteBorrowRecord(int $id) {
    $statement = self::getDatabase()->prepare("UPDATE borrow_record SET returned = 'Y' WHERE `id` = :id");
    $statement->bindValue(':id', $id, \PDO::PARAM_INT);
    return $statement->execute();
  }

  public static function getRecordsByIdAndISBN(string $isbn, int $id = -1) {
    $matchISBN = empty($isbn) ? '1' : 'isbn = :isbn';
    $matchId = ($id < 0) ? '1' : 'user_id = :id';
    $statement = self::getDatabase()->prepare("SELECT * FROM borrow_record WHERE $matchISBN AND $matchId");
    if (!empty($isbn)) $statement->bindValue(':isbn', $isbn);
    if ($id > 0) $statement->bindValue(':id', $id);
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  public static function getBorrowRecords(BorrowRecord $record) {
    // Build the query
    $query = 'SELECT r.id, bv.isbn, u.name, bv.title, r.user_id, r.`borrowDate`, r.`returnDate` FROM book_view bv 
        JOIN borrow_record r 
        ON r.isbn = bv.isbn AND bv.isbn LIKE :isbn AND bv.title LIKE :title
        JOIN user u
        ON u.name LIKE :name AND u.user_id = r.user_id';

    $before = '1';
    $after = '1';
    if (!empty($record->before)) {
      $before = 'r.`returnDate` <= :before';
    }

    if (!empty($record->after)) {
      $after = 'r.`returnDate` >= :after';
    }

    $query = $query . " WHERE $before AND $after AND r.returned = 'N'";


    $statement = self::getDatabase()->prepare($query);
    $statement->bindValue(':isbn', '%' . $record->isbn . '%');
    $statement->bindValue(':title', '%' . $record->title . '%');
    $statement->bindValue(':name', '%' . $record->name . '%');
    if (isset($record->user_id) && !empty($record->user_id)) $statement->bindValue(':id', $record->user_id);
    if (!empty($record->before))
      $statement->bindValue(':before', $record->before);
    if (!empty($record->after))
      $statement->bindValue(':after', $record->after);

    if (isset($record->user_id) && !empty($record->user_id)) {
      $statement->bindValue(':name', $record->user_id, \PDO::PARAM_INT);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
  }
}
