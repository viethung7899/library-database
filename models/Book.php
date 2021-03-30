<?php

namespace app\models;

use app\core\Model;
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
  public ?int $year = NULL;

  // Conflict


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

  // Search by book name with all information
  public static function searchBooksByName(string $title) {
    $keyword = "%$title%";
    $query = self::getDatabase()->prepare("SELECT * FROM book_view WHERE title LIKE :k");
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  // Search by book name with all information
  public static function searchBooksByAuthor(string $author) {
    $keyword = "%$author%";
    $query = self::getDatabase()->prepare("SELECT * FROM book_view WHERE author LIKE :k");
    $query->bindValue(':k', $keyword);
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, self::class);
  }

  public static function getBookByISBN(string $isbn) {
    $query = self::getDatabase()->prepare("SELECT * FROM book_view WHERE isbn = :i");
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
    if (isset($input['title'])) {
      return self::searchBooksByName($input['title']);
    } else if (isset($input['author'])) {
      return self::searchBooksByAuthor($input['author']);
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

  // Doing the cascade delete for book
  public static function deleteBook(string $isbn) {
    
  }
}
