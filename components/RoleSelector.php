<?php

namespace app\components;

use app\components\core\Selector;

class RoleSelector extends Selector {
  public function __construct() {
    parent::__construct('Role', 'role', [
      'Owner',
      'Librarian',
      'Adminstator'
    ]);
  }
}