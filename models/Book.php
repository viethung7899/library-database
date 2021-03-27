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
    $authenticatePublisher = self::getDatabase()->prepare("SELECT * FROM publisher WHERE publisherId = {$data['$publisherId']}");
    if (!$authenticatePublisher->execute()) {
      //ADD PUBLISHER OR ERROR MESSAGE
    }
    $authenticateCategory = self::getDatabase()->prepare("SELECT * FROM category WHERE categoryId = {$data['$categoryId']}");
    if (!$authenticateCategory->execute()) {
      //ADD CATEGORY OR ERROR MESSAGE
    }
    $into = "isbn, title, author, pusblisherId, year, categoryId, quantity, reserveOnly";
    $query = self::getDatabase()->prepare("INSERT INTO book (" . $into . ") VALUES ({$data['isbn']}, {$data['$title']}, {$data['$author']}, {$data['$publisherId']}, {$data['$year']}, {$data['$categoryId']}, {$data['$quantity']}, {$data['$reserveOnly']})");
    $query->execute();
  }

  public static function deleteBook(string $isbn)
  {
  }

  public static function modifyBook($data)
  {
  }
}
