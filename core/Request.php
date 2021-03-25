<?php

namespace app\core;

class Request {
  public static function getPath() {
    $path = $_SERVER['PATH_INFO'] ?? '/';
    return $path;
  }

  public static function method() {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  public static function isGet() {
    return self::method() === 'get';
  }

  public static function isPost() {
    return self::method() === 'post';
  }

  public static function body() {
    $body = [];
    if (self::isGet()) {
      foreach ($_GET as $key => $value) {
        $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }
    if (self::isPost()) {
      foreach ($_POST as $key => $value) {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    return $body;
  }
}
