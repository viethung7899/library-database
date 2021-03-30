<?php

namespace app\models;

use app\core\Model;

include 'Category.php';
class BookAuthor extends Model {
  // Add new book author if it is not exisits
  public static function addOrIgnoreBookAuthor(Book $book) {
    $query = self::getDatabase()->prepare("INSERT INTO book_author (title, author, category_id) VALUES (:t, :a, :i) ON DUPLICATE KEY UPDATE title = :t");
    $query->bindValue(':a', $book->author);
    $query->bindValue(':t', $book->title);
    $query->bindValue(':i', $book->category_id);
    $query->execute();
  }

  // 
  public static function deleteBookAuthor(Book $book) {
    $query = self::getDatabase()->prepare("DELETE from book_author WHERE title = :t AND author = :a");
    $query->bindValue(':a', $book->title);
    $query->bindValue(':t', $book->author);
    $query->execute();
  }
}
