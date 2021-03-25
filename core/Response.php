<?php

namespace app\core;

use app\utils\OutputError;

class Response {
  public array $content = [];
  public OutputError $errors;

  public static function setStatusCode($code) {
    http_response_code($code);
  }

  public static function redirect(string $path) {
    header("Location: $path");
  }

  public function ok() {
    return empty($this->errors);
  }
}
