<?php

namespace app\core;

class Model {
  // Get the instacne of the database
  protected static function getDatabase() {
    return Application::getApp()->getDatabase();
  }

  // Verify the input of the database
  protected static function verifyInput($data, $rules) {
    $error = new \app\utils\OutputError();
    foreach($data as $attr => $value) {
      if (isset($rules[$attr])) {
        foreach ($rules[$attr] as $rule) {
          $mess = \app\utils\Rule::verify($value, $rule);
          $error->addError($attr, $mess);
        }
      }
    }

    return $error;
  }
}