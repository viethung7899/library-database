<?php

namespace app\core;

class Session {
  public function __construct() {
    session_start();
  }

  public function set(string $key, $value) {
    $_SESSION[$key] = $value;
  }

  public function get(string $key) {
    return $_SESSION[$key] ?? false;
  }

  public function remove(string $key) {
    unset($_SESSION[$key]);
  }

  public function reset() {
    foreach($_SESSION as $key => $value) {
      unset($_SESSION[$key]);
    }
  }
}