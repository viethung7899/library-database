<?php

namespace app\models;

use app\core\Model;
use app\utils\Dumpster;
use PDO;

class BookAuthorPublisher extends Model {
  // Add new book author if it is not exisits
  public static function addOrIgnoreBookAuthorPublisher(Book $book) {
    $query = self::getDatabase()->prepare("INSERT INTO book_author_publisher (title, author, publisher_id, year) VALUES (:t, :a, :i, :y) ON DUPLICATE KEY UPDATE title = :t");
    $query->bindValue(':a', $book->author);
    $query->bindValue(':t', $book->title);
    $query->bindValue(':i', $book->publisher_id, PDO::PARAM_INT);
    $query->bindValue(':y', $book->year);
    $query->execute();
  }

  private static function getAllByBookAuthor(Book $book) {
    $query = self::getDatabase()->prepare("SELECT * FROM book_author_publisher WHERE title = :t AND author = :a");
    $query->bindValue(':a', $book->author);
    $query->bindValue(':t', $book->title);
    $query->execute();
    return $query->fetchAll();
  }

  public static function deleteBookAuthorPublisher(Book $book) {
    $query = self::getDatabase()->prepare("DELETE FROM book_author_publisher WHERE title = :t AND author = :a AND publisher_id = :i");
    $query->bindValue(':t', $book->title);
    $query->bindValue(':a', $book->author);
    $query->bindValue(':i', $book->publisher_id, \PDO::PARAM_INT);
    $query->execute();
  }

  public static function shouldDeleteBookAuthorPublisher(Book $book) {
    self::deleteBookAuthorPublisher($book);
    $rows = self::getAllByBookAuthor($book);
    if (empty($rows)) {
      BookAuthor::deleteBookAuthor($book);
    }
  }
}
