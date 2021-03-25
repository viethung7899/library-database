<?php

namespace app\utils;

class Dumpster {
  public static function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
  }

  public static function dumpAll(...$datas) {
    foreach ($datas as $data) {
      self::dump($data);
    }
  }
}