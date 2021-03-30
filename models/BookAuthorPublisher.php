<?php

namespace app\models;

use app\core\Model;
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

  public static function deleteBookAuthor(Book $book) {
    $query = self::getDatabase()->prepare("DELETE from book_author WHERE title = :t AND author = :a");
    $query->bindValue(':a', $book->title);
    $query->bindValue(':t', $book->author);
    $query->execute();
  }
}
