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

  function set_publisherId($pId)
  {
    if (!publisher::checkForPublisher($pId)) {
      //RETURN NO SUCH PUBLISHER OR ADD TO PUBLISHER TABLE BY ASKING FOR NAME SOMEHOW
    } else {
      $this->publisherId = $pId;
    }
  }

  function get_publisherId()
  {
    return $this->publisherId;
  }
}
