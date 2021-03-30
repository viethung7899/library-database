<?php

namespace app\models;

use app\core\Model;
use app\utils\Rule;

class Book extends Model {
  public ?string $isbn = NULL;
  public ?string $title = NULL;
  public ?string $author = NULL;
  public ?string $publisher_id = NULL;
  public ?string $publisher_name = NULL;
  public ?string $category_id = NULL;
  public ?string $category_name = NULL;
  public ?string $quantity = '0';
  public ?string $year = NULL;

  public static function rules() {
    return [
      'isbn' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'title' => [[Rule::REQUIRED]],
      'author' => [[Rule::REQUIRED]],
      'publisher' => [[Rule::REQUIRED]],
      'quantity' => [[Rule::REQUIRED], [Rule::NUMERIC]],
      'year' => [[Rule::REQUIRED], [Rule::NUMERIC]],
    ];
  }

  // Construct by loading data from request
  public function __construct() {
    $this->loadDataFromRequest();
  }

  // Search by book name with all information
  public static function searchBooksByName(string $keyword) {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE book_name LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  // Search by book name with all information
  public static function searchBooksByAuthor(string $keyword) {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE author LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function getBookByISBN(string $isbn) {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE isbn = '$isbn'");
    $query->execute();
    return $query->fetchAll();
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
    BookAuthor::addOrIgnoreBookAuthorPublisher($this);

    // Add or update book table
    self::addOrUpdateBook($this);

    return $response;
  }

  // Either add or update the quantity of books
  public static function addOrUpdateBook(Book $book) {
    $query = self::getDatabase()->prepare("INSERT INTO book (isbn, title, author, publisher_id, quantity) 
      VALUES (:i, :t, :a, :p. :q) ON DUPLICATE KEY UPDATE quantity = quantity + :q)");
    $query->bindValue(':i', $book->isbn);
    $query->bindValue(':t', $book->title);
    $query->bindValue(':a', $book->author);
    $query->bindValue(':p', $book->publisher_id);
    $query->bindValue(':q', $book->quantity);
    $query->execute();
    return $query->fetchAll();
  }

  public static function deleteBook(string $isbn) {
    
  }

  
}
