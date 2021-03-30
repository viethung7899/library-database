<?php

namespace app\models;

use app\core\Model;

class Category extends Model {
  public int $id;
  public string $name;

  public static function getAllCategory() {
    $query = self::getDatabase()->prepare("SELECT * FROM category");
    $query->execute();
    return $query->fetchAll(\PDO::FETCH_CLASS, Category::class);
  }
}
