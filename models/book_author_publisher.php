<?php

namespace app\models;

use app\core\Model;

include 'Publisher.php';
include 'Category.php';

class Book_Author_Publisher extends Model
{
  public $title;
  public $author;
  public $publisherId;
  public $categoryId;
  public $year;
  public $quantity;

  function set_title($title)
  {
    $this->title = $title;
  }

  function get_title()
  {
    return $this->title;
  }

  function set_author($author)
  {
    $this->author = $author;
  }

  function get_author()
  {
    return $this->author;
  }

  function set_publisherId($pId)
  {
    $this->publisherId = $pId;
  }

  function get_publisherId()
  {
    return $this->publisherId;
  }

  function set_categoryId($cId)
  {
    $this->categoryId = $cId;
  }

  function get_categoryId()
  {
    return $this->categoryId;
  }

  function set_year($years)
  {
    $this->year = $years;
  }

  function get_year()
  {
    return $this->year;
  }

  function set_quantity($num)
  {
    $this->quantity = $num;
  }

  function get_quantity()
  {
    return $this->quantity;
  }

  public static function addBook_Author_Publisher($data)
  {
    if (!Book_Author::checkForAuthor($data['author'] && Book_Author::checkForTitle($data['title']))) {
      Book_Author::addBook_Author($data);
    }
    if (!Publisher::checkForPublisher($data)) {
      Publisher::addPublisher($data);
    }
  }
}
