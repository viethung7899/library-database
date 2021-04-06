<?php

namespace app\models;

use app\core\Model;
use app\utils\Dumpster;
use app\utils\Rule;

class Book extends Model {
  public ?string $isbn = NULL;
  public ?string $title = '';
  public ?string $author = NULL;
  public ?int $publisher_id = NULL;
  public ?string $publisher_name = NULL;
  public ?int $category_id = NULL;
  public ?string $category_name = NULL;
  public ?int $quantity = 0;
  public ?int $total = 0;
  public ?int $year = NULL;

  // Implement the validation rules
  public static function rules() {
    return [
      'isbn' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'title' => [[Rule::REQUIRED]],
      'author' => [[Rule::REQUIRED]],
      'publisher_name' => [[Rule::REQUIRED]],
      'quantity' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'year' => [[Rule::REQUIRED], [Rule::NUMERIC]],
    ];
  }

  // Construct by loading data from request
  public function __construct(bool $load = false) {
    if ($load) $this->loadDataFromRequest();
  }

  // Search by book name with all information, no
  public static function searchBooksByName(string $title, array $attr = []) {
    $project = (empty($attr)) ? '*' : implode(',', $attr);
    $query = self::getDatabase()->prepare("SELECT $project, sum(quantity) as total FROM book_view WHERE title LIKE :k GROUP BY $project");
    $keyword = "%$title%";
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Search by book name with all information
  public static function searchBooksByAuthor(string $author, array $attr = []) {
    $keyword = "%$author%";
    $project = (empty($attr)) ? '*' : implode(',', $attr);
    $query = self::getDatabase()->prepare("SELECT $project, sum(quantity) as total FROM book_view WHERE author LIKE :k GROUP BY $project");
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Search by book name with all information
  public static function searchBooksByNameWithDuplicate(string $title, array $attr = []) {
    $project = (empty($attr)) ? '*' : implode(',', $attr);
    $query = self::getDatabase()->prepare("SELECT $project, quantity as total FROM book_view WHERE title LIKE :k");
    $keyword = "%$title%";
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Search by book name with all information
  public static function searchBooksByAuthorWithDuplicate(string $author, array $attr = []) {
    $keyword = "%$author%";
    $project = (empty($attr)) ? '*' : implode(',', $attr);
    $query = self::getDatabase()->prepare("SELECT $project, quantity as total FROM book_view WHERE author LIKE :k");
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  public static function getBookByISBN(string $isbn) {
    $query = self::getDatabase()->prepare("SELECT * FROM book_view WHERE isbn = :i LIMIT 1");
    $query->bindValue(':i', $isbn);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Verification and add book across database
  public function add() {
    $response = $this->verifyInput();

    if (!$response->ok()) {
      return $response;
    }

    // Get the publisher id
    $this->publisher_id = Publisher::addPublisher($this);

    // Add or ignore book and author
    BookAuthor::addOrIgnoreBookAuthor($this);

    // Add or ignore book_author_publisher
    BookAuthorPublisher::addOrIgnoreBookAuthorPublisher($this);


    // Add or update book table
    self::addOrUpdateBook($this);

    return $response;
  }

  // Search books based on input
  public static function search(array $input) {
    // Get all shown attrubite
    $attrs = ['title', 'author'];
    if (isset($input['showISBN'])) {
      $attrs[] = 'isbn';
    }

    if (isset($input['showPublisher'])) {
      $attrs[] = 'publisher_name';
    }

    if (isset($input['showYear'])) {
      $attrs[] = 'year';
    }

    $showDup = isset($input['showDup']);

    if (isset($input['title'])) {
      if ($showDup) return self::searchBooksByNameWithDuplicate($input['title'], $attrs);
      return self::searchBooksByName($input['title'], $attrs);
    } else if (isset($input['author'])) {
      if ($showDup) return self::searchBooksByAuthorWithDuplicate($input['author'], $attrs);
      return self::searchBooksByAuthor($input['author'], $attrs);
    }
    return [];
  }

  // Either add or update the quantity of books
  public static function addOrUpdateBook(Book $book) {
    $query = self::getDatabase()->prepare("INSERT INTO book (isbn, title, author, publisher_id, quantity) 
      VALUES (:i, :t, :a, :p, :q) ON DUPLICATE KEY UPDATE quantity = :q + quantity");
    $query->bindValue(':i', $book->isbn);
    $query->bindValue(':t', $book->title);
    $query->bindValue(':a', $book->author);
    $query->bindValue(':p', $book->publisher_id, \PDO::PARAM_INT);
    $query->bindValue(':q', $book->quantity, \PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();
  }

  // Get all books with same title, author and publisher to a book with a ISBN
  private static function searchByBooksSameTitleAuthorPublisher(string $isbn) {
    $query = self::getDatabase()->prepare("SELECT b1.isbn, b1.title, b1.author, b1.publisher_id
      FROM book b1 JOIN book b2 
      ON b1.title = b2.title AND b1.author = b2.author 
      AND b1.publisher_id = b2.publisher_id AND b2.isbn = :i");
    $query->bindValue(':i', $isbn);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Doing the cascade delete for book
  public static function deleteBook(string $isbn) {
    $books = self::searchByBooksSameTitleAuthorPublisher($isbn);
    $query = self::getDatabase()->prepare("DELETE FROM book WHERE isbn = :i");
    $query->bindValue(':i', $isbn);
    $query->execute();

    // Should delete book_author_publisher ?
    if (count($books) == 1) {
      BookAuthorPublisher::shouldDeleteBookAuthorPublisher($books[0]);
    }
  }

  // Count available books, make sure books is found
  public static function countAvailableBooks(string $isbn) {
    $query = "SELECT sum(quantity) FROM book WHERE isbn = :i - (
      SELECT count(*) FROM reservation WHERE isbn = :i
     + (SELECT count(*) FROM borrow_record WHERE isbn = :i AND returned = 'N'))";
    $statment = self::getDatabase()->prepare($query);
    $statment->bindValue(':i', $isbn);
    $statment->execute();
    return $statment->fetchColumn();
  }

  public static function total() {
    $statement = self::getDatabase()->query('SELECT sum(quantity) FROM book');
    return $statement->fetchColumn();
  }

  public static function countIBSN() {
    $statement = self::getDatabase()->query('SELECT count(*) FROM book');
    return $statement->fetchColumn();
  }

  public static function borrowedByEveryMember() {
    $query = 'SELECT b.isbn, b.title, b.author, b.category_name FROM book_view b WHERE NOT EXISTS (
        SELECT * FROM member m WHERE NOT EXISTS (
          SELECT r.user_id FROM borrow_record r 
            WHERE b.isbn = r.isbn AND r.user_id = m.member_id
        )
      )';
    $statement = self::getDatabase()->query($query);
    return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
  }
}
