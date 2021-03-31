<?php

namespace app\core;

use app\utils\Dumpster;

class Model {
  // Get the instacne of the database
  protected static function getDatabase() {
    return Application::getApp()->getDatabase();
  }

  protected static function rules() {}

  // Verify the input of the database
  protected function verifyInput() {
    $rules = $this->rules();
    $error = new Response();
    foreach($this as $key => $value) {
      if (isset($rules[$key])) {
        foreach ($rules[$key] as $rule) {
          $mess = \app\utils\Rule::verify($value, $rule);
          $error->addError($key, $mess);
        }
      }
    }

    return $error;
  }

  public function loadDataFromRequest() {
    $body = Request::body();
    foreach ($body as $key => $value) {
      $this->{$key} = $value;
    } 
  }
}