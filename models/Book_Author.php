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
    if (!checkForCategoryWithId($categoryId)) {

      //RETURN ERROR BECAUSE NO SUCH CATEGORY
    } else {
      $this->categoryId = $categoryId;
    }
  }
}
