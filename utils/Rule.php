<?php

namespace app\utils;

class Rule {
  const REQUIRED = 0;
  const MIN = 1;
  const MAX = 2;
  const NUMERIC = 3;

  // Verify the rules
  // $rule is an array with more than one element
  // 1st elememt: Rule name
  // 2nd element onward: rule attributes
  public static function verify($value, $rule) {
    switch ($rule[0]) {
      case self::REQUIRED:
        return (strlen(trim($value)) <= 0) ?
          'Required' : '';
      case self::MIN:
        return (strlen(trim($value)) < $rule[1])
          ? 'At least '.$rule[1].' characters' : '';
      case self::MAX:
        return (strlen(trim($value)) > $rule[1])
          ? 'At most '.$rule[1].' characters' : '';
      case self::NUMERIC:
        return (!is_numeric($value))
          ? 'Not a number' : '';
      default:
        return '';
    }
  }
}