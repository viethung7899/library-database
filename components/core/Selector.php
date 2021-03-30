<?php

namespace app\components\core;

use app\core\Component;

class Selector extends Component {
  private string $label;
  private array $options;

  public function __construct(string $label, array $options) {
    $this->label = $label;
    $this->options = $options;
  }

  public function render() {
    echo sprintf('<label class="form-label">%s</label>', $this->label);
    echo '<select class="form-select" name="level">';
    foreach ($this->options as $option => $value) {
      echo sprintf('<option value="%s" selected>%s</option>', $value, is_numeric($option) ? $value : $option);
    }
    echo '</select>';
  }
}