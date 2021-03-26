<?php

namespace app\models;

use app\core\Model;

class Book extends Model {
  public static function searchBooksByName(string $keyword) {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE book_name LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function searchBooksByAuthor(string $keyword) {
    $query = self::getDatabase()->prepare("SELECT * FROM book WHERE author LIKE '%$keyword%'");
    $query->execute();
    return $query->fetchAll();
  }

  public static function getBookByISBN(string $isbn) {
    
  }

  public static function addBook($data) {
    
  }

  public static function deleteBook(string $isbn) {
    
  }

  public static function modifyBook($data) {
    
  }
}