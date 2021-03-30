<?php

namespace app\models;

use app\core\Model;

class Category extends Model
{
  public $categoryId;
  public $cName;
  public static $counter = 0;

  function set_categoryId()
  {
    $this->categoryId = self::$counter;
    self::$counter++;
  }

  function set_name($name)
  {
    $this->cName = $name;
  }

  function get_categoryId()
  {
    return $this->categoryId;
  }

  function get_cName()
  {
    return $this->cName;
  }

  public static function find_categoryId($name)
  {
    $getId = self::getDatabase()->prepare("SELECT categoryId FROM category WHERE name = :n");
    $getId->bindValue(':n', $name);
    $getId->execute();
    $Id = $getId->fetchAll();
    return $Id;
  }

  function find_name($Id)
  {
    $getName = self::getDatabase()->prepare("SELECT cName FROM category WHERE categoryId = :i");
    $getName->bindValue(':i', $Id);
    $getName->execute();
    $namee = $getName->fetchAll();
    return $namee;
  }

  public static function addCategory($data)
  {
    $newCategory = new Category();
    $newCategory->set_categoryId();
    $newCategory->set_name($data['cName']);
    $query = self::getDatabase()->prepare("INSERT INTO category (categoryId, cName) VALUES ( :i, :n)");
    $query->bindValue(':n', $newCategory->get_cName());
    $query->bindValue(':i', $newCategory->get_categoryId());
    $query->execute();
    return $query->fetchAll();
  }

  public static function deleteCategory($data)
  {
    $query = self::getDatabase()->prepare("DELETE from category WHERE categoryId = :i");
    $query->bindValue(':i', $data['categoryId']);
    $query->execute();
    return $query->fetchAll();
  }

  public static function checkForCategory($cName)
  {
    $authenticateCategory = self::getDatabase()->prepare("SELECT * FROM category WHERE cName = :n ");
    $authenticateCategory->bindValue(':n', $cName);
    $authenticateCategory->execute();
    $categories = $authenticateCategory->fetchAll();
    return $categories;
  }
}
