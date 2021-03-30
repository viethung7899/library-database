<?php

namespace app\models;

use app\core\Model;

class Book extends Model
{
  public function checkForPublisher(int $publisherId)
  {
    $authenticatePublisher = self::getDatabase()->prepare("SELECT * FROM publisher WHERE publisherId = '$publisherId'");
    $authenticatePublisher->execute();
    $publishers = $authenticatePublisher->fetchAll();
    return $publishers;
  }
}
