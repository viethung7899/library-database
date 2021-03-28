<?php

namespace app\core;

class Response {
  public array $content = [];
  public array $errors = [];

  public function __construct() {}

  public static function setStatusCode($code) {
    http_response_code($code);
  }

  public static function redirect(string $path) {
    header("Location: $path");
  }

  public function ok() {
    return empty($this->errors);
  }

  public function addError(string $attr, string $value) {
    if (empty($value) || $this->hasError($attr)) return;
    $this->errors[$attr] = $value;
  }

  public function hasError(string $attr) {
    return isset($this->errors[$attr]);
  }
}
