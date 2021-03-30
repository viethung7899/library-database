<?php

namespace app\components\form;

class Form {
  const GET = 'get';
  const POST = 'post';

  private string $action;
  private string $method;
  private object $model;
  private array $errors;

  public function __construct(string $action, string $method, object $model, array $errors) {
    $this->action = $action;
    $this->method = $method;
    $this->model = $model;
    $this->errors = $errors;
  }

  public function begin() {
    echo sprintf('<form action="%s" method="%s" autocomplete="off">', $this->action, $this->method);
  }

  public function end() {
    echo '</form>';
  }

  public function field(string $title, string $attr, bool $showLabel = true, string $type = Field::TEXT) {
    $field = new Field($title, $attr, $type);
    $value = $this->model->{$attr} ?? '';
    $error = $this->errors[$attr] ?? '';
    $field->setData($value, $error);
    if ($showLabel) $field->showLabel();
    return $field;
  }
}