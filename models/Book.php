<?php

namespace app\models;

use app\core\Model;

class Book extends Model
{
  public static function searchBooksByName(string $keyword)
  {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE book_name LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function searchBooksByAuthor(string $keyword)
  {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE author LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function getBookByISBN(string $isbn)
  {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE isbn = '$isbn'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function addBook($data)
  {
    //check if something inputted is null
    foreach ($data as $key => $value) {
      if (!isset($value)) {
        //IF NULL SEND ERROR MESSAGE 
        //RETURN
      }
    }
    //cheeck if publisher is in publisher table
    $authenticatePublisher = self::getDatabase()->prepare("SELECT * FROM publisher WHERE publisherId = $data[publisherId]");
    $authenticatePublisher->execute();
    $publishers = $authenticatePublisher->fetchAll();
    if (!$publishers) {
      //ADD PUBLISHER OR ERROR MESSAGE
    }
    //check if category is in category table
    $authenticateCategory = self::getDatabase()->prepare("SELECT * FROM category WHERE categoryId = $data[categoryId]");
    $authenticateCategory->execute();
    $categories = $authenticateCategory->fetchAll();
    if (!$categories) {
      //ADD CATEGORY OR ERROR MESSAGE
    }
    $authenticateBookAuthor = self::getDatabase()->prepare("SELECT * FROM book_author WHERE title = $data[title] AND author = $data[author]");
    $authenticateBookAuthor->execute();
    $BookAuthor = $authenticateBookAuthor->fetchAll();
    if (!$BookAuthor) {
      //ADD BOOK_AUTHOR OR ERROR MESSAGE
    }
    $authenticateBookAuthorPublisher = self::getDatabase()->prepare("SELECT * FROM book_author WHERE title = $data[title] AND author = $data[author] AND publisher = $data[publisher]");
    $authenticateBookAuthorPublisher->execute();
    $BookAuthorPublisher = $authenticateBookAuthorPublisher->fetchAll();
    if (!$BookAuthorPublisher) {
      //ADD BOOK_AUTHOR_PUBLISHER OR ERROR MESSAGE
    }
    $into = "isbn, title, author, pusblisherId, year, categoryId, quantity, reserveOnly";
    $query = self::getDatabase()->prepare("INSERT INTO book (" . $into . ") VALUES ($data[isbn], $data[title], $data[author], $data[publisherId], $data[year], $data[categoryId], $data[quantity], $data[reserveOnly])");
    $query->execute();
    return $query->fetchAll();
  }

  public static function deleteBook(string $isbn)
  {
    $query = self::getDatabase()->prepare("DELETE FROM book WHERE isbn = :isbn");
    $query->bindValue(':isbn', $isbn);
    $query->execute();
  }

  public static function modifyBook($data)
  {
  }
}
