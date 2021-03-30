<?php

namespace app\models;

use app\core\Model;

include 'Category.php';
class Book_Author extends Model
{
  public $title;
  public $author;
  public $categoryId;

  function set_categoryId($categoryId)
  {
    if (!category::checkForCategoryWithId($categoryId)) {

      //RETURN ERROR BECAUSE NO SUCH CATEGORY
    } else {
      $this->categoryId = $categoryId;
    }
  }

  function set_title($title)
  {
    $this->title = $title;
  }

  function set_author($author)
  {
    $this->author = $author;
  }

  function get_title()
  {
    return $this->title;
  }

  function get_author()
  {
    return $this->author;
  }

  function get_categoryId()
  {
    return $this->categoryId;
  }

  public static function addBook_Author($data)
  {
    $newBook_Author = new Book_Author();
    $newBook_Author->set_author($data['author']);
    $newBook_Author->set_title($data['title']);
    $newBook_Author->set_categoryId($data['categoryId']);
    $query = self::getDatabase()->prepare("INSERT INTO Book_Author (title, author, categoryId) VALUES ( :t, :a, :i)");
    $query->bindValue(':a', $newBook_Author->get_author());
    $query->bindValue(':t', $newBook_Author->get_title());
    $query->bindValue(':i', $newBook_Author->get_categoryId());
    $query->execute();
    return $query->fetchAll();
  }

  public static function deleteBook_Author($data)
  {
    $query = self::getDatabase()->prepare("DELETE from book_author WHERE title = :t AND author = :a");
    $query->bindValue(':a', $data['author']);
    $query->bindValue(':t', $data['title']);
    $query->execute();
    return $query->fetchAll();
  }
  public static function checkForTitle($title)
  {
    $authenticateTitle = self::getDatabase()->prepare("SELECT * FROM author_book WHERE title = :t");
    $authenticateTitle->bindValue(':t', $title);
    $authenticateTitle->execute();
    $titles = $authenticateTitle->fetchAll();
    return $titles;
  }
  public static function checkForAuthor($author)
  {
    $authenticateAuthor = self::getDatabase()->prepare("SELECT * FROM author_book WHERE author = :a ");
    $authenticateAuthor->bindValue(':a', $author);
    $authenticateAuthor->execute();
    $authors = $authenticateAuthor->fetchAll();
    return $authors;
  }
}
