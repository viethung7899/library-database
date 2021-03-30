<?php

namespace app\components\core;

use app\core\Component;

class Selector extends Component {
  private string $label;
  private string $name;
  private array $options;

  public function __construct(string $label, string $name, array $options) {
    $this->label = $label;
    $this->name = $name;
    $this->options = $options;
  }

  public function render() {
    echo sprintf('<label class="form-label">%s</label>', $this->label);
    echo sprintf('<select class="form-select" name="%s">', $this->name);
    foreach ($this->options as $option => $value) {
      echo sprintf('<option value="%s" selected>%s</option>', $value, is_numeric($option) ? $value : $option);
    }
    echo '</select>';
  }
}