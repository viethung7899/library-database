<?php

namespace app\components;

use app\components\core\Selector;

class LevelSelector extends Selector {
  public function __construct() {
    parent::__construct('Access Level', 'level', 
    [
      'Librarian' => 1,
      'Adminstator' => 2
    ]);
  }
}