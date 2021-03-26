<?php

namespace app\utils;

class Rule {
  const REQUIRED = 0;
  const MIN = 1;
  const MAX = 2;

  // Verify the rules
  public static function verify($value, $rule) {
    switch ($rule[0]) {
      case self::REQUIRED:
        return (strlen($value) <= 0) ?
          'Required' : '';
      case self::MIN:
        return (strlen($value) < $rule[1])
          ? 'At least '.$rule[1].' characters' : '';
      case self::MAX:
        return (strlen($value) > $rule[1])
          ? 'At most '.$rule[1].' characters' : '';
      default:
        return '';
    }
  }
}