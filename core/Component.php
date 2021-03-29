<?php

namespace app\core;

abstract class Component {
  protected array $state;

  public function __construct(array $state = []) {
    $this->state = $state;
  }

  public abstract function render();
}