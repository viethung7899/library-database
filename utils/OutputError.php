<?php

namespace app\utils;

class OutputError {
  public array $content;

  public function __construct() {
    $this->content = [];
  }

  public function hasError(string $name) {
    return isset($this->content[$name]);
  }

  public function addError(string $name, string $value) {
    if (empty($value) || $this->hasError($name)) return;
    $this->content[$name] = $value;
  }

  public function isEmpty() {
    return empty($this->content);
  }
}
