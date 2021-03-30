<?php

namespace app\models;

use app\core\Model;

class Publisher extends Model
{
  public $publisherId;
  public $pName;
  public static $counter = 0;

  function set_publisherId()
  {
    $this->publisherId = self::$counter;
    self::$counter++;
  }

  function set_name($name)
  {
    $this->pName = $name;
  }

  function get_publisherId()
  {
    return $this->publisherId;
  }

  function get_pName()
  {
    return $this->pName;
  }

  public static function find_publisherId($name)
  {
    $getId = self::getDatabase()->prepare("SELECT publisherId FROM publisher WHERE name = '$name'");
    $getId->execute();
    $Id = $getId->fetchAll();
    return $Id;
  }

  function find_name($Id)
  {
    $getName = self::getDatabase()->prepare("SELECT pName FROM publisher WHERE publisherId = '$Id'");
    $getName->execute();
    $namee = $getName->fetchAll();
    return $namee;
  }

  public static function addPublisher($data)
  {
    $newPublisher = new Publisher();
    $newPublisher->set_publisherId();
    $newPublisher->set_name($data['pName']);
    $query = self::getDatabase()->prepare("INSERT INTO publisher (publisherId, pName) VALUES ( :i, :n)");
    $query->bindValue(':n', $newPublisher->get_pName());
    $query->bindValue(':i', $newPublisher->get_publisherId());
    $query->execute();
    return $query->fetchAll();
  }

  public static function deletePublisher($data)
  {
    $query = self::getDatabase()->prepare("DELETE from publisher WHERE publisherId = :n");
    $query->bindValue(':n', $data['publisherId']);
    $query->execute();
    return $query->fetchAll();
  }

  public static function checkForPublisher(int $publisherId)
  {
    $authenticatePublisher = self::getDatabase()->prepare("SELECT * FROM publisher WHERE publisherId = '$publisherId'");
    $authenticatePublisher->execute();
    $publishers = $authenticatePublisher->fetchAll();
    return $publishers;
  }
}
